<?php

namespace App\Admin\Controllers;

use App\Model\ThirdLogin;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ThirdLoginController extends Controller
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

            $content->header('三方登录记录');
            $content->description('三方登录记录');

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
        return Admin::grid(ThirdLogin::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('userId','用户ID');

            $grid->column('uid','三方的uid');
            $grid->column('platform','三方平台 默认为2微信（平台参见友盟）');
            $grid->column('screen_name','用户名');
            $grid->column('iconurl','头像')->image(50,50);
            //$grid->column('accessToken','accessToken');
            //$grid->column('refreshToken','refreshToken');
            $grid->column('gender','性别');
            //$grid->column('unionid','unionid');
            //$grid->column('openid','openid');
            $grid->column('expires_in','过期时间');
            //$grid->column('other','其它');
            $grid->created_at();
            $grid->updated_at();
            $grid->model()->orderBy('created_at','desc');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ThirdLogin::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('userId','用户ID');

            $form->display('uid','三方的uid');
            $form->display('platform','三方平台 默认为2微信（平台参见友盟）');
            $form->display('screen_name','用户名');
            $form->display('iconurl','头像');
            $form->display('accessToken','accessToken');
            $form->display('refreshToken','refreshToken');
            $form->display('gender','性别');
            $form->display('unionid','unionid');
            $form->display('openid','openid');
            $form->display('expires_in','过期时间');
            $form->display('other','其它');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
