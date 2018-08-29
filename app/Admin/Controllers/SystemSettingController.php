<?php

namespace App\Admin\Controllers;

use App\Model\SystemSetting;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SystemSettingController extends Controller
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

            $content->header('系统配置');
            $content->description('系统整体配置');

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

            $content->header('编辑配置');
            $content->description('编辑配置');

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

            $content->header('创建配置');
            $content->description('创建配置');

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
        return Admin::grid(SystemSetting::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('key','键');
            $grid->column('val','值');
            $grid->column('remark','备注');

            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('status','状态')->switch($states);
            $grid->column('createdBy.username', '创建人');
            $grid->column('updatedBy.username', '修改人');
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(SystemSetting::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('key','键');
            $form->text('val','值');
            $form->textarea('remark','备注');

            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $form->switch('status','状态')->states($states)->default(0);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
            $form->hidden('created_by','创建者');
            $form->hidden('updated_by','修改者');
            $form->saving(function (Form $form){
                if(empty($form->created_by)) {
                    $form->created_by = Admin::user()->id;
                }
                $form->updated_by = Admin::user()->id;
            });
        });
    }
}
