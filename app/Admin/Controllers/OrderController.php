<?php

namespace App\Admin\Controllers;

use App\Model\Order;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderController extends Controller
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

            $content->header('订单管理');
            $content->description('订单管理');

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
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('trade_parent_id','淘宝父订单号');
            $grid->column('trade_id','淘宝订单号');
            $grid->column('num_iid','商品ID');
            $grid->column('item_title','商品标题');
            $grid->column('item_num','商品数量');
            $grid->column('price','单价');
            $grid->column('pay_price','实际支付金额');
            $grid->column('seller_nick','卖家昵称');
            $grid->column('seller_shop_title','卖家店铺名称');
            $grid->column('commission','推广者获得的收入金额，对应联盟后台报表“预估收入”');
            $grid->column('commission_rate','推广者获得的分成比率，对应联盟后台报表“分成比率”');
            $grid->column('unid','推广者unid（已废弃）');
            $grid->column('userInfo.nickname','用户昵称');
            $grid->column('create_time','淘客订单创建时间');
            $grid->column('click_time','淘客订单点击时间');
            $grid->column('earning_time','淘客订单结算时间');
            $grid->column('settlement_amount','结算金额');
            $grid->column('technical_service_fee_ratio','技术服务费比率');

            $grid->column('tk_status','淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功');
            $grid->column('tk3rd_type','第三方服务来源，没有第三方服务，取值为“--”');
            $grid->column('tk3rd_pub_id','第三方推广者ID');
            $grid->column('order_type','订单类型，如天猫，淘宝');
            $grid->column('income_rate','收入比率，卖家设置佣金比率+平台补贴比率');
            $grid->column('pub_share_pre_fee','效果预估，付款金额*(佣金比率+补贴比率)*分成比率');
            $grid->column('subsidy_rate','补贴比率');
            $grid->column('subsidy_type','补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4');
            $grid->column('terminal_type','成交平台，PC:1，无线:2');
            $grid->column('auction_category','类目名称');
            $grid->column('site_id','来源媒体ID');
            $grid->column('site_name','来源媒体名称');
            $grid->column('adzone_id','广告位ID');
            $grid->column('adzone_name','广告位名称');
            $grid->column('alipay_total_price','付款金额');
            $grid->column('total_commission_rate','佣金比率');
            $grid->column('total_commission_fee','佣金金额');
            $grid->column('subsidy_fee','补贴金额');
            $grid->column('relation_id','渠道关系ID');

            $grid->created_at();
            $grid->updated_at();
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->equal('num_iid', '商品ID');
                $filter->equal('siteId', 'siteId');
                $filter->equal('adzone_id', '广告位ID(adzoneId)');
                $filter->equal('unid', '用户ID');
                $filter->equal('tk_status', '淘客订单状态')->select(['3'=>'订单结算','12'=>'订单付款', '13'=>'订单失效','14'=>'订单成功']);

            });
            $grid->disableActions();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
