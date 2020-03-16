<?php

namespace App\Console\Commands;

use App\BigdataArea;
use App\BigdataCode;
use Illuminate\Console\Command;

class BigdataurlsRequest extends Command
{

    /**
     * pcode
     * 机械五金 1
     * 橡胶塑料 8
     * 冶炼钢材 21
     * 化工精细 31
     * 纺织市场 42
     * 电子电工 45
     * 电力能源 49
     * 数码家电 53
     * 食品饮料 64
     * 日用百货 68
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:bigdata-urls {pcode=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate url via pcode-param:run:  bigdata-urls pcode';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $areaArr = BigdataArea::all()->toArray();


        $hangyeArr = BigdataCode::where('pcode', $this->argument('pcode'))->get()->toArray();


        $str = '';

        foreach ($hangyeArr as $k1 => $v1) {

            $str = "http://data.stats.gov.cn/easyquery.htm?m=QueryData&dbcode=fsyd&rowcode=zb&colcode=sj&dfwds=" . '[{"wdcode":"zb","valuecode":"' . $v1['code'] . '"}]' . "&k1=" . time();
            $area_str = '';
            foreach ($areaArr as $k2 => $v2) {
                $area_str = "&wds=" . '[{"wdcode":"reg","valuecode":"' . $v2['code'] . '"}]';
                $url_str = $str . $area_str . "\n";
                file_put_contents(storage_path('urls.txt'), $url_str, FILE_APPEND);
                $area_str = '';

            }
        }


    }

}
