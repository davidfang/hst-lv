<?php

namespace App\Admin\Controllers;

use App\Model\DgSearch;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DgSearchController extends Controller
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
        return Admin::grid(DgSearch::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('keyWord','搜索关键词');
            $grid->column('title','产品');
            $grid->column('coupon_info','优惠券面额');
            $grid->column('reserve_price','商品一口价格');
            $grid->column('zk_final_price','商品折扣价格');
            $grid->column('zk_final_price_wap','无线折扣价');

            $grid->column('yongjin','佣金')->display(function (){
                return $this->tk_rate * $this->zk_final_price_wap / 100;
            });
            $grid->column('tk_rate','佣金比例')->display(function (){
                return $this->tk_rate .'%';
            });
            $grid->column('pict_url','商品主图')->image('',50,50);
            $grid->created_at();
            $grid->updated_at();
            $grid->disableCreateButton();

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(DgSearch::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
