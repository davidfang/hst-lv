<?php

namespace App\Admin\Controllers;

use App\Model\AppVersion;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AppVersionController extends Controller
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

            $content->header('APP版本管理');
            $content->description('APP版本管理');

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

            $content->header('APP版本编辑');
            $content->description('APP版本编辑');

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

            $content->header('新建APP版本');
            $content->description('新建APP版本');

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
        return Admin::grid(AppVersion::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->columns('name','APP名称');
            $grid->columns('platform','APP平台');
            $grid->columns('version','版本号');
            $grid->columns('description','版本说明');
            $grid->columns('appUrl','更新地址');

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
        return Admin::form(AppVersion::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','APP名称');
            $form->select('platform','APP平台')->options(['ios'=>'ios','android'=>'android'])->default('android');
            $form->text('version','版本号');
            $form->textarea('description','版本说明');
            $form->textarea('appUrl','更新地址');
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $form->switch('status','状态')->states($states)->default(0);
            $form->hidden('created_by');
            $form->hidden('updated_by');
            $form->saving(function (Form $form){
                if(empty($form->created_by)) {
                    $form->created_by = Admin::user()->id;
                }
                $form->updated_by = Admin::user()->id;
            });

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
