<?php

namespace App\Console\Commands;

use App\Bigdata;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BigdataRequest extends Command
{
    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 7;  // 同时并发抓取

    private $urls = [];


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:bigdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Scrapy bigdata via Guzzle. Note：before execute this command, execute command [run:bigdata-urls]";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $urls_str = @file_get_contents(storage_path('urls.txt'));
        $urls_str  =trim($urls_str,"\n");
        $this->urls = explode("\n",$urls_str);
//        dd($this->urls);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->totalPageCount = count($this->urls);

        $client = new Client();


        $requests = function ($total) use ($client) {
            foreach ($this->urls as $key => $url) {
                yield function () use ($client, $url) {
                    return $client->getAsync($url);
                };
            }
        };


        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) {

                $this->info('当前请求的索引为： '.$index.' : '.$this->urls[$index]);

                $areacode = $this->parse_areacode($index);
                $returndata = json_decode($response->getBody()->getContents(), true);
                if ($returndata['returncode'] == 200) {

                    $sqldata = [];
                    $wdnodes = $returndata['returndata']['wdnodes'];
                    $nodes = $wdnodes[0]['nodes'];
                    $tnodes = $wdnodes[2]['nodes'];
                    $datanodes = $returndata['returndata']['datanodes'];

                    foreach ($nodes as $k1 => $v1) {

                        $code = $v1['code'];

                        foreach ($tnodes as $k2 => $v2) {
                            $sqldata[$k1][$k2]['tvalue'] = $v2['cname'];
                            $sqldata[$k1][$k2]['code'] = $code;
                            $sqldata[$k1][$k2]['titem'] = $v2['code'];
                            $sqldata[$k1][$k2]['areacode'] = $areacode;
                            foreach ($datanodes as $k3 => $v3) {
                                if ($v3['code'] == ('zb.' . $code . '_reg.' . $areacode . '_sj.' . $sqldata[$k1][$k2]['titem'])) {
                                    $sqldata[$k1][$k2]['t_data'] = $v3['data']['data'];
                                    $sqldata[$k1][$k2]['t_str_data'] = $v3['data']['strdata'];
                                }
                            }
                        }
                    }

                    //数据入库
                    $this->insertTable($sqldata);

                    $this->info('索引为'.$index.'的请求数据处理完毕');

                }

            },
            'rejected' => function ($reason, $index) {
                Log::error("rejected，索引为: ".$index.' : '.$this->urls[$index]);
                $this->error("rejected，索引为: ".$index.' : '.$this->urls[$index]);
                $this->error("rejected reason: " . $reason);
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();

    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }

    /**
     * 根据请求连接获取areadcode，作为入库参数
     * @param $index 请求连接索引
     * @return mixed
     */
    private  function parse_areacode($index)
    {
        parse_str(parse_url($this->urls[$index])['query'],$query_arr);
        $wds = json_decode($query_arr['wds'],true);
        $areacode = $wds[0]['valuecode'];
        return $areacode;
    }

    /**
     * guzzle请求数据入库：若数据存在，则更新，若数据不存在，则插入数据
     * @param $data
     */
    public function insertTable($data)
    {
        if(count($data)>0){
            foreach ($data as $k=>$v){
                if(count($v)>0){
                    foreach ($v as $k2=>$v2){
                        Bigdata::updateOrCreate(
                            ['areacode'=>$v2['areacode'],'code'=>$v2['code'],'titem'=>$v2['titem']],
                            ['tvalue'=>$v2['tvalue'],'t_data'=>$v2['t_data'],'t_str_data'=>$v2['t_str_data']]
                        );
                    }
                }
            }
        }
    }


}
