<?php

namespace App\Admin\Controllers;

use App\Model\GoodsCategory;
use App\Model\Product;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProductController extends Controller
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

            $content->header('产品管理列表');
            $content->description('产品列表');

            $content->body($this->grid());
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

            $content->header('产品编辑');
            $content->description('产品编辑');

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

            $content->header('新建产品');
            $content->description('新建产品');

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

            //$grid->id('ID')->sortable();
            $grid->column('num_iid', '商品ID');
            $grid->column('title', '商品标题');
            $grid->column('pict_url', '商品主图')->image(100, 100);
            $grid->column('my_category_id', '系统分类ID')->editable('select', GoodsCategory::allSelectOptions())->sortable();
            $grid->column('reserve_price', '商品一口价格')->sortable();
            $grid->column('zk_final_price', '商品折扣价格')->sortable();
            $grid->column('coupon_end_time', '优惠券结束时间')->sortable();
            $grid->column('coupon_info_price', '优惠券面额（数值）')->sortable();
            $grid->column('coupon_info', '优惠券面额');
            $grid->column('coupon_start_time', '优惠券开始时间');
            $grid->column('coupon_total_count', '优惠券总量');
            $grid->column('coupon_remain_count', '优惠券剩余量');
            //$grid->column('coupon_id','优惠券id');
            $grid->column('commission_rate', '佣金比率')->sortable();
            $grid->column('commission_type', '佣金类型')->display(function ($commission_type) {
                $array = ['MKT' => '营销计划', 'SP' => '定向计划', 'COMMON' => '通用计划'];
                return isset($array[$commission_type]) ? $array[$commission_type] : $commission_type;
            });

//            $grid->column('category_id','叶子类目id');
//            $grid->column('small_images','商品小图列表');
//            $grid->column('user_type','卖家类型，0表示集市，1表示商城');
//            $grid->column('provcity','宝贝所在地');
//            $grid->column('item_url','商品地址');
//            $grid->column('seller_id','卖家id');
//            $grid->column('volume','30天销量');
//            $grid->column('shop_title','店铺名称');
//            $grid->column('info_dxjh','定向计划信息');
//            $grid->column('tk_total_sales','淘客30天月推广量');
//            $grid->column('tk_total_commi','月支出佣金');
//            $grid->column('include_mkt','是否包含营销计划');
//            $grid->column('include_dxjh','是否包含定向计划');
//            $grid->column('shop_dsr','店铺dsr评分');
//            $grid->column('coupon_share_url','券二合一页面链接');
//            $grid->column('url','商品淘客链接');
//            $grid->column('level_one_category_name','一级类目名称');
//            $grid->column('level_one_category_id','一级类目ID');
//            $grid->column('category_name','叶子类目名称');
//            $grid->column('short_title','商品短标题');
//            $grid->column('white_image','商品白底图');
//            $grid->column('oetime','拼团：结束时间');
//            $grid->column('ostime','拼团：开始时间');
//            $grid->column('jdd_num','拼团：几人团');
//            $grid->column('jdd_price','拼团：拼成价，单位元');
//            $grid->column('uv_sum_pre_sale','预售数量');
//
//
//            $grid->column('detail','产品详情');
//            $grid->column('tpwd','淘口令');
//            $grid->column('tpwd_created_at','淘口令生成时间');

            //$grid->created_at();
            //$grid->updated_at();

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->equal('num_iid', '淘宝产品ID');
                $filter->equal('my_category_id')->select(GoodsCategory::allSelectOptions());
                $filter->like('title', '产品名称');
                $filter->date('created_at', '创建时间');

            });
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

            $form->display('my_category_id', '系统分类ID');

            $form->display('category_id', '叶子类目id');
            $form->display('num_iid', '商品ID');
            $form->display('title', '商品标题');
            $form->display('pict_url', '商品主图');
            $form->multipleImage('small_images', '商品小图列表');
            $form->display('reserve_price', '商品一口价格');
            $form->display('zk_final_price', '商品折扣价格');
            $form->display('user_type', '卖家类型，0表示集市，1表示商城');
            $form->display('provcity', '宝贝所在地');
            $form->display('item_url', '商品地址');
            $form->display('seller_id', '卖家id');
            $form->display('volume', '30天销量');
            $form->display('shop_title', '店铺名称');
            $form->display('coupon_end_time', '优惠券结束时间');
            $form->display('coupon_info_price', '优惠券面额（数值）');
            $form->display('coupon_info', '优惠券面额');
            $form->display('coupon_start_time', '优惠券开始时间');
            $form->display('coupon_total_count', '优惠券总量');
            $form->display('coupon_remain_count', '优惠券剩余量');


            $form->display('info_dxjh', '定向计划信息');
            $form->display('tk_total_sales', '淘客30天月推广量');
            $form->display('tk_total_commi', '月支出佣金');
            $form->display('coupon_id', '优惠券id');
            $form->display('include_mkt', '是否包含营销计划');
            $form->display('include_dxjh', '是否包含定向计划');
            $form->display('commission_rate', '佣金比率');
            $form->display('commission_type', '佣金类型 MKT表示营销计划，SP表示定向计划，COMMON表示通用计划');
            $form->display('shop_dsr', '店铺dsr评分');
            $form->display('coupon_share_url', '券二合一页面链接');
            $form->display('url', '商品淘客链接');
            $form->display('level_one_category_name', '一级类目名称');
            $form->display('level_one_category_id', '一级类目ID');
            $form->display('category_name', '叶子类目名称');
            $form->display('short_title', '商品短标题');
            $form->display('white_image', '商品白底图');
            $form->display('oetime', '拼团：结束时间');
            $form->display('ostime', '拼团：开始时间');
            $form->display('jdd_num', '拼团：几人团');
            $form->display('jdd_price', '拼团：拼成价，单位元');
            $form->display('uv_sum_pre_sale', '预售数量');


            $form->multipleImage('detail', '产品详情');
            $form->display('tpwd', '淘口令');
            $form->display('tpwd_created_at', '淘口令生成时间');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
