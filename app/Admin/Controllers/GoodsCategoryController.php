<?php

namespace App\Admin\Controllers;

use App\Model\GoodsCategory;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use function foo\func;

class GoodsCategoryController extends Controller
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

            $content->header('产品分类');
            $content->description('产品分类管理');

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

            $content->header('产品分类');
            $content->description('产品分类管理');

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

            $content->header('产品分类');
            $content->description('产品分类管理');

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
        return Admin::grid(GoodsCategory::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('parentCategory.title', '上级分类');
            $grid->column('title', '分类');
            $grid->column('img_path', '图片')->image('', 30, 30);


            /***************淘宝搜索设置   开始****************************/

            /***************淘宝搜索设置   结束****************************/


            $states = [
                'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('updated_goods', '是否更新产品')->switch($states);
            $grid->column('status', '状态')->switch($states);
            /*$grid->column('status', '状态')->display(function ($k) {
                $array = ['禁用','启用' ];
                return $array[$k] ?: null;
            });*/

            $grid->column('category_sort', '分类排序');
            $grid->column('collected_total', '采集商品数量');
            $grid->column('start_coupon_rate', '优惠券起始金额');
            $grid->column('q', '查询词')->editable('text');
            $sortOptions = [
                'total_sales_des' => '销量降序',
                'total_sales_asc' => '销量升序',
                'tk_rate_des' => '淘客佣金比率降序',
                'tk_rate_asc' => '淘客佣金比率升序',
                'tk_total_sales_des' => '累计推广量降序',
                'tk_total_sales_asc' => '累计推广量升序',
                'tk_total_commi_des' => '总支出佣金降序',
                'tk_total_commi_asc' => '总支出佣金升序',
                'price_des' => '价格降序',
                'price_asc' => '价格升序'
            ];
            $booleStates = [
                'on' => ['value' => 'true', 'text' => '高于', 'color' => 'primary'],
                'off' => ['value' => 'false', 'text' => '低于', 'color' => 'default'],
            ];
            $grid->column('sort', '搜索排序')->editable('select',$sortOptions);
            $grid->column('start_tk_rate', '淘客佣金比率下限')->editable('text');
            $grid->column('include_pay_rate_30', '成交转化/行业均值')->switch($booleStates);
            $grid->column('include_good_rate', '好评率/行业均值')->switch($booleStates);
            $grid->column('include_rfd_rate', '退款率/行业均值')->switch($booleStates);
            //$grid->column('createdBy.username', '创建人');
            //$grid->column('updatedBy.username', '修改人');
            //$grid->created_at('创建时间');
            //$grid->updated_at('修改时间');


            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                //$filter->disableIdFilter();
                $filter->like('title', '分类名称');
                $filter->equal('parent_id', '上级分类')->select(GoodsCategory::selectOptions());;
                $filter->equal('status','状态')->select([1=>'是',0=>'否']);
                //$filter->date('created_at','创建时间');

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
        return Admin::form(GoodsCategory::class, function (Form $form) {
            $boolStates = [
                'on' => ['value' => 'true', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => 'false', 'text' => '否', 'color' => 'default'],
            ];

            $form->tab('基本信息', function (Form $form) {
                $form->display('id', 'ID');
                $form->text('title', '分类');
                $form->select('parent_id', '上级')->options(GoodsCategory::selectOptions());
                $form->image('img_path', '图标')->resize(55, 55)->uniqueName();
                $states = [
                    'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
                    'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
                ];
                $form->switch('updated_goods', '是否更新产品')->states($states)->default(0);
                $form->switch('status', '状态')->states($states)->default(0);
                $form->number('category_sort', '分类排序');
                $form->display('created_by', '创建人');
                $form->display('updated_by', '修改人');
                $form->display('created_at', '创建时间');
                $form->display('updated_at', '更新时间');
            })->tab('采集关键设置', function (Form $form) use ($boolStates) {
                /***************淘宝搜索设置   开始****************************/
                $form->text('q', '查询词')->help('查询词');
                $sortOptions = [
                    'total_sales_des' => '销量降序',
                    'total_sales_asc' => '销量升序',
                    'tk_rate_des' => '淘客佣金比率降序',
                    'tk_rate_asc' => '淘客佣金比率升序',
                    'tk_total_sales_des' => '累计推广量降序',
                    'tk_total_sales_asc' => '累计推广量升序',
                    'tk_total_commi_des' => '总支出佣金降序',
                    'tk_total_commi_asc' => '总支出佣金升序',
                    'price_des' => '价格降序',
                    'price_asc' => '价格升序'
                ];
                $form->radio('sort', '搜索排序')->options($sortOptions)->help('排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate）， 累计推广量（tk_total_sales），总支出佣金（tk_total_commi），价格（price）');
                $form->text('cat', '后台类目ID')->help('后台类目ID，用,分割，最大10个，该ID可以通过taobao.itemcats.get接口获取到');
                $form->text('material_id', '官方的物料Id')->help('官方的物料Id(详细物料id见：https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8576096)，不传时默认为2836');
                $form->switch('has_coupon', '是否有优惠券')->states($boolStates)->default('true')->help('是否有优惠券，设置为true表示该商品有优惠券，设置为false或不设置表示不判断这个属性');
                $form->number('collected_total', '采集商品数量')->default(50);
                $form->number('start_coupon_rate', '优惠券起始金额')->default(10);
                $form->number('page_size', '页大小')->default(20)->help('页大小，默认20，1~100');
                $form->number('page_no', '第几页')->default(1)->help('第几页，默认：１');


            })->tab('采集其它设置', function (Form $form) use ($boolStates) {

                //$form->number('end_tk_rate', '淘客佣金比率上限')->help('淘客佣金比率上限，如：1234表示12.34%');
                $form->number('start_tk_rate', '淘客佣金比率下限')->help('淘客佣金比率下限，如：1234表示12.34%');
                //$form->number('end_price', '折扣价范围上限')->help('折扣价范围上限，单位：元');
                $form->number('start_price', '折扣价范围下限')->help('折扣价范围下限，单位：元');
                //$form->number('end_ka_tk_rate', 'KA媒体淘客佣金比率上限')->help('如：1234表示12.34%');
                //$form->number('start_ka_tk_rate', 'KA媒体淘客佣金比率下限')->help('如：1234表示12.34%');
                $form->text('adzone_id')->help('mm_xxx_xxx_xxx的第三位');
                $form->switch('is_overseas', '是否海外商品')->states($boolStates)->default('false')->help('是否海外商品，设置为true表示该商品是属于海外商品，设置为false或不设置表示不判断这个属性');
                $form->switch('is_tmall', '是否商城商品')->states($boolStates)->default('false')->help('是否商城商品，设置为true表示该商品是属于淘宝商城商品，设置为false或不设置表示不判断这个属性');

                $form->number('start_dsr', '店铺dsr评分')->help('店铺dsr评分，筛选高于等于当前设置的店铺dsr评分的商品0-50000之间');
                $form->radio('platform', '链接形式')->options(['1' => 'PC', '2' => '无线'])->default('2')->help('链接形式：1：PC，2：无线，默认：１');
                $form->text('itemloc', '所在地')->help('所在地');
                $form->text('ip')->help('ip参数影响邮费获取，如果不传或者传入不准确，邮费无法精准提供');
                $form->switch('need_free_shipment', '是否包邮')->states($boolStates)->default('false')->help('是否包邮，true表示包邮，空或false表示不限');
                $form->switch('need_prepay', '消费者保障')->states($boolStates)->default('false')->help('是否加入消费者保障，true表示加入，空或false表示不限');
                $form->switch('include_pay_rate_30', '成交转化')->states($boolStates)->default('true')->help('成交转化是否高于行业均值');
                $form->switch('include_good_rate', '好评率')->states($boolStates)->default('true')->help('好评率是否高于行业均值');
                $form->switch('include_rfd_rate', '退款率')->states($boolStates)->default('true')->help('退款率是否低于行业均值');
                $form->radio('npx_level', '牛皮癣程度')->options(['1' => '不限', '2' => '无', '3' => '轻微'])->default('1')->help('取值：1:不限，2:无，3:轻微');
                $form->text('device_encrypt', '设备号加密类型')->help('设备号加密类型：MD5');
                $form->text('device_value', '设备号加密后的值')->help('设备号加密后的值');
                $form->text('device_type', '设备号类型')->help('设备号类型：IMEI，或者IDFA，或者UTDID');
                /***************淘宝搜索设置   结束****************************/

            });


        });
    }
}
