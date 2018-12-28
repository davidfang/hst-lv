<?php

namespace App\Admin\Controllers;

use App\Common\TaoBao;
use App\Model\GoodsCategory;
use App\Model\Product;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;

class CaijiController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            //$content->body($this->grid());
            $content->body('hello world');
//            $content->row(function(Row $row) {
//                $row->column(4, 'foo');
//                $row->column(4, 'bar');
//                $row->column(4, 'baz');
//            });
//            $content->row(function(Row $row) {
//                $row->column(4, 'foo');
//                $row->column(4, 'bar');
//                $row->column(4, 'baz');
//            });


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

            GoodsCategory::where([['title','女装']])->chunk(50,function ($goodsCategories) use ($content,$dbDict){
                $content->body('分类采集开始');
                foreach ($goodsCategories as $goodsCategory){
                    $products = [];
//                    $page = $goodsCategory->page_no;
                    $page = 2;
                    $taobao = new TaoBao();
                    do{
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
                                            //var_dump(array_diff_key($dbDict, $searchResult));
                                            //var_dump(array_diff_key($searchResult, $dbDict));
                                        }

                                        if (empty(array_diff_key($dbDict, $searchResult)) && empty(array_diff_key($searchResult, $dbDict))) {//检查数据字段不少
                                            //dd(array_flip(array_keys($searchResult)));
                                            $products[] = $searchResult;//将搜索到的产品加入到产品队列中
                                            $spiderTotal++;
                                        }else{
                                            $content->row('检查字段失败一条');
                                        }
                                    }
                                }else{
                                    //$this->info('优惠券面值：'.$coupon_info[2][0] .' 设定优惠券取值：'. $goodsCategory->start_coupon_rate .' 销量：'. $searchResult['volume'] .' 设定销量:'. $goodsCategory->volume);
                                }



                                //显示开始
                                $content->row(function (Row $row) use ($searchResult,$goodsCategory,$dbDict){
                                    $row->column(5,$searchResult['title']);

                                    preg_match_all('/满(\d*.\d*)元减(\d*)元/', $searchResult['coupon_info'], $coupon_info);
                                    if(isset($coupon_info[2][0])){
                                        $row->column(2,'有优惠券');
                                        if($coupon_info[2][0] >= $goodsCategory->start_coupon_rate){
                                            $row->column(1,$coupon_info[2][0].'券大于'.$goodsCategory->start_coupon_rate);
                                        }else{
                                            $row->column(1,$coupon_info[2][0].'券小于'.$goodsCategory->start_coupon_rate);
                                        }

                                    }else{
                                        $row->column(1,'没有优惠券');
                                        $row->column(1,'券 0');
                                    }

                                    if($searchResult['volume'] >= $goodsCategory->volume){
                                        $row->column(1,$searchResult['volume'].'销量大于'.$goodsCategory->volume);
                                    }else{
                                        $row->column(1,$searchResult['volume'].'销量小于'.$goodsCategory->volume);
                                    }

                                    if (isset($searchResult['small_images'])) {//必须有小图的产品才能被收录
                                        $row->column(1,'有小图');
                                    }else{
                                        $row->column(1,'无小图');
                                    }

                                    if (empty(array_diff_key($dbDict, $searchResult)) && empty(array_diff_key($searchResult, $dbDict))) {//检查数据字段不少
                                        $row->column(1,'检查字段成功');
                                    }else{
                                        if(!empty(array_diff_key($dbDict, $searchResult))) {
                                            $row->column(1, 'A检查字段失败' . join(',', array_diff_key($dbDict, $searchResult)));
                                        }
                                        if(!empty(array_diff_key($searchResult, $dbDict))){
                                            $row->column(1, 'B检查字段失败' . join(',', array_diff_key( $searchResult,$dbDict)));
                                        }
                                    }

                                });

                                //显示结束

                            }
                        }
                        $content->row("-----分类：$goodsCategory->title  第 $page 页 采集 $spiderTotal 条-----");
                        $page++;
                    }while(false);
                    //}while($page < $taobao->getPages() && count($products) <= $goodsCategory->collected_total);//当前页比淘宝查出结果页少 并且 已采集条数少于设定的采集条数
                }
            });




        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Product::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Product::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
