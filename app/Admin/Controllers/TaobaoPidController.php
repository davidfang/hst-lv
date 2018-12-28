<?php

namespace App\Admin\Controllers;

use App\Model\TaobaoPid;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TaobaoPidController extends Controller
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

            $content->header('淘宝客PID管理');
            $content->description('淘宝客PID管理');

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
        return Admin::grid(TaobaoPid::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('pid','淘宝PID');
            $grid->column('name','名称');
            $grid->column('siteId');
            $grid->column('adzoneId','广告位ID(adzoneId)');
            $grid->column('userId');
            $grid->column('userInfo.nickname','用户名');
            $grid->column('taobaoId');

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->equal('pid', '淘宝PID');
                $filter->equal('siteId', 'siteId');
                $filter->equal('adzoneId', '广告位ID(adzoneId)');
                $filter->equal('userId', '用户ID');
                $filter->equal('taobaoId', '淘宝ID');

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
        return Admin::form(TaobaoPid::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
