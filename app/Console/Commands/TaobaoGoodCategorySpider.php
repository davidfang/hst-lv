<?php

namespace App\Console\Commands;

use App\Common\TaoBao;
use App\Helpers\ArrayHelper;
use App\Model\GoodsCategory;
use App\Model\Product;
use Illuminate\Console\Command;

class TaobaoGoodCategorySpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:goodsCategorySpider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '产品分类采集';

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

        GoodsCategory::where([['status', '1']])->chunk(50, function ($goodsCategories) use ($dbDict) {
            $this->info('---------分类采集开始--------');
            foreach ($goodsCategories as $goodsCategory) {
                $products = [];
                //dd($goodsCategory);
                $page = $goodsCategory->page_no;
                $taobao = new TaoBao();
                do {
                    $spiderTotal = 0;//采集数量


                    $param = [

                        "start_dsr" => '',
                        "page_size" => '',
                        //"page_no" => '',
                        "platform" => '',
                        "end_tk_rate" => '',
                        "start_tk_rate" => '',
                        "end_price" => '',
                        "start_price" => '',
                        "is_overseas" => '',
                        "is_tmall" => '',
                        "sort" => '',
                        "itemloc" => '',
                        "cat" => '',
                        "q" => '',
                        //"material_id" => '',
                        "has_coupon" => '',
                        "ip" => '',
                        "adzone_id" => '',
                        "need_free_shipment" => '',
                        "need_prepay" => '',
                        "include_pay_rate_30" => '',
                        "include_good_rate" => '',
                        "include_rfd_rate" => '',
                        "npx_level" => '',
                        //"end_ka_tk_rate" => '',
                        //"start_ka_tk_rate" => '',
                        //"device_encrypt" => '',
                        //"device_value" => '',
                        //"device_type" => '',
                    ];
                    foreach ($param as $k => $v) {
                        $param[$k] = $goodsCategory->$k;
                    }
                    $param['page_no'] = $page;
                    $searchResults = $taobao->searchDg($param);
                    //dd($searchResults);
                    if ($searchResults) {
                        $searchResults = json_encode($searchResults);
                        $searchResults = json_decode($searchResults, true);
                        foreach ($searchResults as $searchResult) {//对搜索结果进行处理
                            preg_match_all('/满(\d*.\d*)元减(\d*)元/', $searchResult['coupon_info'], $coupon_info);
                            if (isset($coupon_info[2][0]) && $coupon_info[2][0] >= $goodsCategory->start_coupon_rate && $searchResult['volume'] >= $goodsCategory->volume) {//大于设定优惠券面额  30天销量大于设定的值 才加入
                                $searchResult['my_category_id'] = $goodsCategory->id;
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
                                        $spiderTotal++;
                                    }
                                }
                            }
                        }
                        //dd($searchResults);

                    }
                    $this->info("-----分类：$goodsCategory->title  第 $page 页 采集 $spiderTotal 条-----");
                    $page++;
                } while ($page < $taobao->getPages() && count($products) <= $goodsCategory->collected_total);//当前页比淘宝查出结果页少 并且 已采集条数少于设定的采集条数
                if (!empty($products)) {
                    $productsIndex = ArrayHelper::index($products, 'num_iid');
                    $productsModels = Product::find(array_keys($productsIndex), ['num_iid'])->toArray();
                    if (!empty($productsModels)) {//数据表中有对应的产品
                        foreach ($productsModels as $productsModel) {
                            unset($productsIndex[$productsModel['num_iid']]);//删除对应的产品，不需要插入
                        }
                    }
                    $productsValues = array_values($productsIndex);

                    //echo serialize($productsValues);

                    \DB::table('product')->insert($productsValues);
                    $this->info('数据库插入一次');
                    $this->info(count($productsIndex));
                    //dd($productsValues);
                    //$this->table(['short_title','coupon_info'],$products);


                    $this->info(" $goodsCategory->title 采集完毕 共 " . count($productsValues));
                }
            }
        });
    }
}
