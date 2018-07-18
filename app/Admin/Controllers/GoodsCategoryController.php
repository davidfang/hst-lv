<?php

namespace App\Admin\Controllers;

use App\Model\GoodsCategory;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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
            $grid->column('parentCategory.title','上级分类');
            $grid->column('title','分类');
            $grid->column('img_path','图片')->image('',30,30);
            $grid->column('status', '状态')->display(function ($k) {
                $array = ['禁用','启用' ];
                return $array[$k] ?: null;
            });
            $grid->column('sort','排序');
            $grid->column('createdBy.username','创建人');
            $grid->column('updatedBy.username','修改人');
            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
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

            $form->display('id', 'ID');
            $form->text('title','分类');
            $form->select('parent_id','上级')->options('/api/parent-goods-category');
            $form->image('img_path', '图标')->uniqueName();
            $form->radio('status', '状态')->options(['禁用','启用' ]);
            $form->number('sort','排序');
            $form->display('created_by','创建人');
            $form->display('updated_by','修改人');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
