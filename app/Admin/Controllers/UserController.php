<?php

namespace App\Admin\Controllers;

use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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

            $content->header('用户管理');
            $content->description('注册用户管理');

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

            $content->header('用户管理');
            $content->description('注册用户管理');

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

            $content->header('用户管理');
            $content->description('注册用户管理');

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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('name', '名字');
            $grid->column('nickname', '昵称');
            $grid->column('age', '年龄');
            $grid->column('gender', '性别')->display(function ($k) {
                $array = ['未设置', '男', '女'];
                return $array[$k] ?: null;
            });
            $grid->column('mobile', '手机');
            $grid->column('avatar', '头像')->image('', 50, 50);
            $grid->column('status', '状态')->display(function ($k) {
                $array = ['禁用', '正常', '异常'];
                return $array[$k] ?: null;
            });
            $grid->column('grade', '等级')->display(function ($k) {
                $array = ['VIP会员', '超级会员', '运营商'];
                return $array[$k] ?: null;
            });
            $grid->column('parentUser.mobile', '父ID手机');

            $grid->created_at();
            //$grid->updated_at();

            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('mobile', '手机');
            $form->password('password', '密码')->rules('required|confirmed');
            $form->password('password_confirmation', '确认密码')->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });
            $form->ignore(['password_confirmation']);

            $form->text('name', '姓名');
            $form->text('nickname', '昵称');
            $form->text('age', '年龄');
            $form->select('gender', '性别')->options(['未设置', '男', '女']);
            $form->image('avatar', '头像')->uniqueName();
            $form->radio('status', '状态')->options(['正常', '禁用', '异常']);
            $form->select('grade', '等级')->options(['VIP会员', '超级会员', '运营商']);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
            $form->saved(function (Form $form) {
                $model = $form->model();
                if($model->invitation_code == null){
                    $model->invitation_code = createInvitationCode($model->id);
                    $model->save();
                }
            });
        });
    }
}
