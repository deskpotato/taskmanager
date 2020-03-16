<?php


namespace App\Http\Controllers;

use App\Bigdata;
use GuzzleHttp\Client;

class BigdataController extends Controller
{
    private  $url = 'http://data.stats.gov.cn/easyquery.htm?m=QueryData&dbcode=fsyd&rowcode=zb&colcode=sj&dfwds=[{"wdcode":"zb","valuecode":"A02020Y"}]&k1=1584153078228&wds=[{"wdcode":"reg","valuecode":"110000"}]';

    public function __construct()
    {

    }

    public function  index()
    {
        //titem   tvalue  code t_data  t_str_data  areacode
        parse_str(parse_url($this->url)['query'],$query_arr);
        $wds = json_decode($query_arr['wds'],true);
        $areacode = $wds[0]['valuecode'];




        $client = new Client();
        $response = $client->request('GET',$this->url);
        $returndata =json_decode($response->getBody()->getContents(),true);
        if($returndata['returncode']==200){
            $sqldata = [];
            $wdnodes = $returndata['returndata']['wdnodes'];
            # 名称数组
            $nodes = $wdnodes[0]['nodes'];
            # 月份数组
            $tnodes = $wdnodes[2]['nodes'];
            $datanodes = $returndata['returndata']['datanodes'];

            foreach ($nodes as $k1=>$v1){

                $code = $v1['code'];

                foreach ($tnodes as $k2=>$v2){
                    $sqldata[$k1][$k2]['tvalue'] = $v2['cname'];
                    $sqldata[$k1][$k2]['code'] = $code;
                    $sqldata[$k1][$k2]['titem']  = $v2['code'];
                    $sqldata[$k1][$k2]['areacode']  = $areacode;
                    foreach ($datanodes as $k3=>$v3){
                        if($v3['code'] == ('zb.'.$code.'_reg.'.$areacode.'_sj.'.$sqldata[$k1][$k2]['titem'])){
                            $sqldata[$k1][$k2]['t_data'] = $v3['data']['data'];
                            $sqldata[$k1][$k2]['t_str_data'] = $v3['data']['strdata'];
                        }
                    }
                }
            }
            dd($sqldata);

            print_r('插入数据开始');
            //数据库插入数据

            $this->insertTable($sqldata);

            print_r('插入数据完毕');



        }
    }

    /**
     * @param $data
     * 数据入库
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
