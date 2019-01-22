<?php

namespace App\Console\Commands;

use App\Common\TaoBao;
use App\Helpers\ArrayHelper;
use App\Model\Product;
use Illuminate\Console\Command;

class SpiderByGoodsId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
    }
    public $goodsId = [];//要搜索的产品ID数组
    public $goodsOption = [];//要搜索的产品属性
    /**
     * 根据产品ID抓取产品
     * @param $categoryByGoods \App\Model\CategoryByGoods
     * @param $pageno 页码
     */
    public function speedByTaobao($categoryByGoods)
    {
        //业务逻辑：先根据商品ID采集商品信息，获得产品标题，根据产品标题搜索产品，从搜索结果中找到对应的产品ID的那条信息，存入对应的数据库

        //$goodsCategoryId = $categoryByGoods->categoryId;//产品分类ID;
        //$goodsCategoryTitle = $categoryByGoods->categoryName;//产品分类名称;
        $goodsId = explode(',', $categoryByGoods->goodsId);//产品ID组合以逗号分割
        //$pageno = $categoryByGoods->id;

        //先去产品表查产品，已经存在的，不用去淘宝抓取
        $oldProducts = Product::whereIn('num_iid', $goodsId)->get(['num_iid']);
        //dd($oldProducts);
        foreach ($oldProducts as $oldProduct) {
            $key = array_search($oldProduct->num_iid, $goodsId);
            if ($key !== false) {
                unset($goodsId[$key]);//删除数据表已经有的
            }
        }

        //集成产品属性供抓取后插入数据库
        foreach ($goodsId as $goodsIdKey) {
            $this->goodsOption[$goodsIdKey] = [
                'goodsCategoryId' => $categoryByGoods->categoryId,//产品分类ID;
                'goodsCategoryTitle' => $categoryByGoods->categoryName,//产品分类名称;
                'categoryByGoodsTableId' => $categoryByGoods->id //分类采集产品表的ID
            ];
        }


        $this->goodsId = array_merge($this->goodsId, $goodsId);

        if (count($this->goodsId) < 40) {//小于40条
            return;
        } else {//大于等于40条
            $goodsIdChunk = array_chunk($this->goodsId,40);
            $goodsId = $goodsIdChunk[0];
            //dd($goodsId);
            if(isset($goodsIdChunk[1])){//大于40条的情况
                $this->goodsId = $goodsIdChunk[1];//剩余的重新进入队列
            }else{
                $this->goodsId = [];//不大于40条
            }

            $this->spiderByTaobaoGoodsIds($goodsId);
        }

        $categoryByGoods->status = 'true';//更新产品采集状态为已经采集
        $categoryByGoods->save();

    }

    /**
     * 具体执行 根据产品ID从淘宝抓取产品
     * @param $goodsId array
     */
    public function spiderByTaobaoGoodsIds($goodsId){

        $taobo = new TaoBao();
        //数据表字段配置数组
        $dbDict = [
            "category_id" => 0,
            "category_name" => 1,
            "commission_rate" => 2,
            "commission_type" => 3,
            "coupon_end_time" => 4,
            "coupon_id" => 5,
            "coupon_info" => 6,
            "coupon_remain_count" => 7,
            "coupon_share_url" => 8,
            "coupon_start_time" => 9,
            "coupon_total_count" => 10,
            "include_dxjh" => 11,
            "include_mkt" => 12,
            "info_dxjh" => 13,
            "item_url" => 14,
            "level_one_category_id" => 15,
            "level_one_category_name" => 16,
            "num_iid" => 17,
            "pict_url" => 18,
            "provcity" => 19,
            "reserve_price" => 20,
            "seller_id" => 21,
            "shop_dsr" => 22,
            "shop_title" => 23,
            "short_title" => 24,
            "small_images" => 25,
            "title" => 26,
            "tk_total_commi" => 27,
            "tk_total_sales" => 28,
            "url" => 29,
            "user_type" => 30,
            "volume" => 31,
            "white_image" => 32,
            "zk_final_price" => 33,
            "my_category_id" => 34,
            "coupon_info_price" => 35,
            "real_price" => 36,
            "commission_amount" => 37
        ];

        //1.根据商品ID获得商品信息，获得商品标题
        $goodsInfo = $taobo->tbkItemInfoGetRequest(join(',',$goodsId));
        //var_dump($goodsId);
        //dd($goodsInfo);
        if ($goodsInfo) {//搜索到商品列表信息
            $products = [];
            foreach ($goodsInfo as $goodInfo) {
                $title = $goodInfo->title;
                //2.根据商品标题搜索产品，筛选对应产品ID的商品想入数据库
                $searchResults = $taobo->searchDg(['q' => $title]);//搜索产品
                //dd($searchResults);
                if ($searchResults) {
                    $searchResults = json_encode($searchResults);
                    $searchResults = json_decode($searchResults, true);
                    //dd($searchResults);
                    foreach ($searchResults as $searchResult) {//对搜索结果进行处理
                        if(isset($searchResult['x_id'])){
                            unset($searchResult['x_id']);//删除多余的字段
                        }
                        if ($searchResult['num_iid'] == $goodInfo->num_iid) {
                            preg_match_all('/满(\d*.\d*)元减(\d*)元/', $searchResult['coupon_info'], $coupon_info);
                            if (isset($coupon_info[2][0])) {//大于设定优惠券面额  30天销量大于设定的值 才加入
                                $searchResult['my_category_id'] = $this->goodsOption[$goodInfo->num_iid]['goodsCategoryId'] ;//产品分类ID;
                                $searchResult['coupon_info_price'] = $coupon_info[2][0];
                                $searchResult['real_price'] = bcsub($searchResult['zk_final_price'], $searchResult['coupon_info_price'], 2);//真实价格
                                $searchResult['commission_amount'] = bcdiv(bcmul($searchResult['commission_rate'], $searchResult['real_price'], 2), 10000, 2); //佣金金额
                                if (isset($searchResult['small_images'])) {//必须有小图的产品才能被收录
                                    //var_dump($searchResult['small_images']);
                                    $searchResult['small_images'] = json_encode($searchResult['small_images']['string']);

                                    //$searchResult['coupon_share_url'] = 'https:'.$searchResult['coupon_share_url'];
                                    //var_dump(array_diff_key($dbDict, $searchResult));
                                    if (!empty(array_diff_key($dbDict, $searchResult)) || !empty(array_diff_key($searchResult, $dbDict))) {
                                        var_dump(array_diff_key($dbDict, $searchResult));
                                        var_dump(array_diff_key($searchResult, $dbDict));
                                    }

                                    if (empty(array_diff_key($dbDict, $searchResult)) && empty(array_diff_key($searchResult, $dbDict))) {//检查数据字段不少
                                        //dd(array_flip(array_keys($searchResult)));
                                        $products[] = $searchResult;//将搜索到的产品加入到产品队列中

                                    } else {
                                        $this->warn('检查字段失败一条');
                                    }
                                }
                            } else {
                                //$this->info('优惠券面值：'.$coupon_info[2][0] .' 设定优惠券取值：'. $goodsCategory->start_coupon_rate .' 销量：'. $searchResult['volume'] .' 设定销量:'. $goodsCategory->volume);
                            }
                        }
                    }
                }
            }

            if (!empty($products)) {//要添加的产品不为空
                $productsIndex = ArrayHelper::index($products, 'num_iid');
//                $productsModels = Product::find(array_keys($productsIndex), ['num_iid'])->toArray();
//                if (!empty($productsModels)) {//数据表中有对应的产品
//                    foreach ($productsModels as $productsModel) {
//                        unset($productsIndex[$productsModel['num_iid']]);//删除对应的产品，不需要插入
//                    }
//                }
                $productsValues = array_values($productsIndex);

                //echo serialize($productsValues);

                \DB::table('product')->insert($productsValues);
                $this->info('数据库插入一次 ' . count($productsIndex) . ' 条');
                //dd($productsValues);
                //$this->table(['short_title','coupon_info'],$products);


                //$this->info(" $goodsCategoryTitle 第 $pageno 页 采集完毕 共 " . count($productsValues) . ' 条');
            }

        } else {
            $this->warn('没搜索到ID对应的商品');
        }
        foreach ($goodsId as $goodsIdKey) {
            unset($this->goodsOption[$goodsIdKey]);//删除抓取产品的属性信息
        }


    }
}
