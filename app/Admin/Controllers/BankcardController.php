<?php

namespace App\Admin\Controllers;

use App\Model\ Bankcard;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BankcardController extends Controller
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
        return Admin::grid( Bankcard::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('user_id','用户ID');
            $grid->column('userInfo.nickname','用户昵称');
            $grid->column('channel','类别');
            $grid->column('bank_name','银行名称');
            $grid->column('name','姓名');
            $grid->column('bank_card_no','银行卡号（支付宝号）');
            $grid->created_at();
            $grid->updated_at();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->model()->orderBy('created_at','desc');
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                //$filter->disableIdFilter();
                $filter->equal('user_id', '用户ID');
                $filter->like('name', '姓名');

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
        return Admin::form( Bankcard::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
