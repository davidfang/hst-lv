<?php

namespace App\Admin\Controllers;

use App\Model\Account;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AccountController extends Controller
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

            $content->header('账户管理');
            $content->description('账户管理');

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
        return Admin::grid(Account::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('user_id','用户ID');
            $grid->column('userInfo.nickname','用户昵称');
            $grid->column('amount','总金额')->sortable();
            $grid->column('cash_balance','可提现余额')->sortable();
            $grid->column('uncash_balance','不可提现余额')->sortable();
            $grid->column('freeze_cash_balance','可提现冻结余额')->sortable();
            $grid->column('freeze_uncash_balance','不可提现冻结余额')->sortable();
            $states = [
                'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('status', '状态')->switch($states);
            $grid->column('updatedBy.username', '修改人');

            $grid->created_at();
            $grid->updated_at();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->model()->orderBy('amount', 'desc');
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                //$filter->disableIdFilter();
                $filter->equal('user_id', '用户ID');

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
        return Admin::form(Account::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
