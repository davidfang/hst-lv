<?php

namespace App\Admin\Controllers;

use App\Model\Article;

use App\Model\ArticleCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleController extends Controller
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

            $content->header('文章列表');
            $content->description('文章列表');

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

            $content->header('编辑文章');
            $content->description('编辑文章');

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

            $content->header('创建文章');
            $content->description('创建文章');

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
        return Admin::grid(Article::class, function (Grid $grid) {

            $grid->id('ID')->sortable();


            $grid->column('slug','slugen');
            $grid->column('title','标题');
            $grid->column('body','介绍');
            $grid->column('category.title','分类');
            $grid->column('sort','排序');
            $grid->column('view','模板名称');
            $grid->column('thumbnail','缩略图')->image('',50,50);
            /*$grid->column('images','图集')->display(function ($images) {

                return json_decode($images, true);

            })->image('', 30, 30);*/
            $grid->column('images','图集')->image('', 30, 30);
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('status','状态')->switch($states);
            $grid->column('click','点击次数');
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
        return Admin::form(Article::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('slug','slugen');
            $form->text('title','标题');
            $form->textarea('body','介绍');
            $form->select('category_id','分类')->options(ArticleCategory::allSelectOptions());
            $form->number('sort','排序');
            $form->image('thumbnail','缩略图')->uniqueName()->resize(400,600);
            $form->multipleImage('images','图集')->uniqueName()->removable()->resize(400,600);
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $form->switch('status','状态')->states($states)->default(0);
            $form->number('click','点击次数');

            $form->hidden('created_by');
            $form->hidden('updated_by');
            $form->saving(function (Form $form){
                if(empty($form->created_by)) {
                    $form->created_by = Admin::user()->id;
                }
               $form->updated_by = Admin::user()->id;
            });
//            $form->display('created_by','创建者');
//            $form->display('updated_by','修改者');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
