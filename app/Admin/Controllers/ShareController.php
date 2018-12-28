<?php

namespace App\Admin\Controllers;

use App\Model\Share;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShareController extends Controller
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

            $content->header('分享管理');
            $content->description('分享统计');

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
        return Admin::grid(Share::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('uid','用户ID');
            $grid->column('content','为分享内容');
            $grid->column('img','为图片地址')->image(100, 100);
            $grid->column('url','为分享链接');
            $grid->column('title','为分享链接的标题');
            $grid->column('platform','为平台id');
            $grid->column('type')->display(function($type){
                $types = ['1'=>'圈子','2'=>'用户', '3'=>'产品'];
                return $types[$type];
});//->default('1','类型 1为圈子 2用户 3产品 ');
            $grid->column('code','错误码');//->help('code为错误码，当为0时，标记成功');
            $grid->column('message','message为错误信息');
            $grid->column('other','其它信息，供后台操作使用，json形式');


            $grid->created_at();
            $grid->updated_at();

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
        return Admin::form(Share::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
