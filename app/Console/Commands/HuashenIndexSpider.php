<?php

namespace App\Console\Commands;

use App\Common\TaoBao;
use App\Helpers\ArrayHelper;
use App\Model\CategoryByGoods;
use App\Model\Product;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class HuashenIndexSpider extends SpiderByGoodsId
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'huasheng:indexSpider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '花生首页产品采集 产品到数据和淘宝抓取同时进行';

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
        $client = new Client();
        $uri = 'https://hsrjapi.huasheng100.com/homgPage/guessLikeList';//首页推荐
        $pageno = 1;
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

        do {
            $goodsIdArray = [];
            $res = $client->request('POST', $uri, [
                'form_params' => ['pageno' => $pageno, 'pagesize' => 20]
            ]);
            if ($res->getStatusCode() == 200) {//请求成功
                $body = $res->getBody();
                //echo $body;
                //dd(json_decode($body, true));
                $body = json_decode($body, true);
                if ($body['status'] == 200) {
                    $goodsIdArray = ArrayHelper::getColumn($body['data']['guessLike'], 'goodsId');
                    //$this->line(join(',', $goodsIdArray));
                    $categoryByGoodsArray = [
                        'categoryName' => '首页推荐',//'分类名称'
                        'categoryId' => '18410557',//'分类ID'
                        'goodsId' => join(',', $goodsIdArray),//'产品IDs'
                        'date' => date('Y-m-d'),//'日期'
                        'channel' => '花生首页',//'采集渠道'
                        //'status'=>'false',//'采集状态'
                    ];
                    $categoryByGoods = CategoryByGoods::firstOrCreate($categoryByGoodsArray);
                    if ($categoryByGoods->status != 'true') {
                        $this->speedByTaobao($categoryByGoods);
                    }
                    $pageno++;
                } else {
                    $this->line('花生首页返回出错 ' . json_encode($body));
                    break;
                }

            } else {
                $this->warn('花生首页请求出错' . $res->getBody());
                break;
            }
            //sleep(rand(3, 8));
            if ($pageno > 15) {
                break;
            }
        } while (count($goodsIdArray) == 20);
        $this->spiderByTaobaoGoodsIds($this->goodsId);//最后将不足40条的抓取出来
        $this->goodsId = [];//重置产品IDS
        $this->goodsOption = [];//重置产品属性信息
    }
}
