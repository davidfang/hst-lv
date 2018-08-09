<?php

namespace App\Admin\Controllers;

use App\Model\ArticleCategory;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleCategoryController extends Controller
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

            $content->header('文章分类');
            $content->description('文章分类管理');

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

            $content->header('修改文章分类');
            $content->description('修改文章分类');

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

            $content->header('创建文章分类');
            $content->description('创建文章分类');

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
        return Admin::grid(ArticleCategory::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('slug','slugen');
            $grid->column('title','标题');
            $grid->column('body','介绍');
            $grid->column('parent_id','上级分类id');
            $grid->column('sort','排序');
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('status','状态')->switch($states);
            $grid->column('createdBy.username', '创建人');
            $grid->column('updatedBy.username', '修改人');

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
        return Admin::form(ArticleCategory::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('slug','slugen');
            $form->text('title','标题');
            $form->textarea('body','介绍');
            $form->select('parent_id','上级')->options('/api/parent-article-category')->default(0);
            $form->number('sort','排序');
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $form->switch('status','状态')->states($states)->default(0);
            $form->display('created_by','创建者');
            $form->display('updated_by','修改者');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
