<?php

namespace App\Admin\Controllers;

use App\Model\Tpwd;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TpwdController extends Controller
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

            $content->header('点击口令');
            $content->description('口令点击统计');

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
        return Admin::grid(Tpwd::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('num_iid', '淘宝产品ID');
            $grid->column('userId', '用户ID');
            $grid->column('title', '产品名称');
            $grid->column('pict_url', '产品图片')->image(100, 100);
            $grid->column('zk_final_price', '价格');
            $grid->column('real_price', '券后价');
            $grid->column('coupon_info_price', '优惠券面值');
            $grid->column('commission_rate', '佣金比例')->sortable();
            $grid->column('commission_amount', '佣金金额')->sortable();
            $grid->column('click', '点击次数')->sortable();
            $grid->column('buy', '购买次数')->sortable();
            $grid->created_at();
            $grid->updated_at();


            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->equal('num_iid','淘宝产品ID');
                $filter->like('title', '产品名称');
                $filter->date('created_at','创建时间');

            });
            $grid->model()->orderBy('id', 'desc');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Tpwd::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
