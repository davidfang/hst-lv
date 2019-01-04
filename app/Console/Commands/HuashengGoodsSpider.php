<?php

namespace App\Console\Commands;

use App\Helpers\ArrayHelper;
use App\Model\CategoryByGoods;
use App\Model\CategorySpider;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class HuashengGoodsSpider extends SpiderByGoodsId
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huasheng:goodsSpider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '花生产品抓取 只是从花生到数据表，还未从淘宝抓取';

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


        /**
         *
         * https://hsrjapi.huasheng100.com/goods/goodsList
         * cid    1
         * pageno    1
         * pagesize    20
         * sortType    1
         *
         *
         */
        $categorySpiders = CategorySpider::all();
        //$categorySpiders = CategorySpider::where('updated_at' ,'<',date('Y-m-d'))->get();
        //$categorySpiders = CategorySpider::whereNull('updated_at' )->get();

        foreach ($categorySpiders as $categorySpider) {

            $this->spiderByCategory($categorySpider);
            $categorySpider->updated_at = date('Y-m-d H:i:s');
            $categorySpider->save();
            //dd($categorySpider);
        }

    }


    /**
     * 根据分类抓取
     * @param $categorySpider \App\Model\CategorySpider
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function spiderByCategory($categorySpider)
    {
        $client = new Client();
        $uri = 'https://api.drgou.com/goods/queryByCategoryList';//分类产品列表

        $pageno = 1;
        do {
            $goodsIdArray = [];
            $categoryCode = $categorySpider->categoryCode;
            $queryTag = $categorySpider->queryTag;//'母婴';
            $categoryName = $categorySpider->name;//'母婴';
            $categoryId = $categorySpider->my_category_id;//'18508986';
            $res = $client->request('POST', $uri, [
                'form_params' => [
                    'categoryCode' => $categoryCode,
                    'pageno' => $pageno,
                    'pagesize' => '20',
                    'queryTag' => $queryTag,
                    'queryTarget' => 'level_class',
                    'queryType' => '1'
                    //sign:MvMtEerQOHDPRnUmFk+bStad4us=
                    //sortType:0
                    //timeStamp:1546408180000
                    //token:f194253e8cdf42b38493af9a6bc3d46d_17245226_2
                ]
            ]);


            if ($res->getStatusCode() == 200) {//请求成功
                $body = $res->getBody();
                //echo $body;
                //dd(json_decode($body, true));
                $body = json_decode($body, true);
                if ($body['status'] == 200) {
                    $goodsIdArray = ArrayHelper::getColumn($body['data']['goodsList'], 'goodsId');//注意这里是goodsList
                    //$this->line(join(',', $goodsIdArray));
                    $categoryByGoodsArray = [
                        'categoryName' => $categoryName,//'分类名称'
                        'categoryId' => $categoryId,//'分类ID'
                        'goodsId' => join(',', $goodsIdArray),//'产品IDs'
                        'date' => date('Y-m-d'),//'日期'
                        'channel' => '花生 ' . $queryTag,//'采集渠道'
                        //'status'=>'false',//'采集状态'
                    ];
                    $categoryByGoods = CategoryByGoods::firstOrCreate($categoryByGoodsArray);
//                    if ($categoryByGoods->status != 'true') {
//                        $this->speedByTaobao($categoryByGoods, $pageno);
//                    }
                    $this->line("$categoryName 第 $pageno 页 采集完毕 共 ".count($goodsIdArray)." 条");//
                    $pageno++;
                } else {
                    $this->line("花生产品抓取返回出错 categoryName: $categoryName categoryId: $categoryId categoryCode: $categoryCode" . json_encode($body));
                    break;
                }

            } else {
                $this->warn("花生产品抓取失败 categoryName: $categoryName categoryId: $categoryId categoryCode: $categoryCode" . $res->getBody());
                break;
            }
            //sleep(rand(3, 8));
            if ($pageno > 15) {//最多取15页，多的不要再采集了
                break;
            }

        } while (count($goodsIdArray) == 20);
    }
}
