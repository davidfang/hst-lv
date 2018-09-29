<?php

namespace App\Admin\Controllers;

use App\Model\Invite;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class InviteController extends Controller
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

            $content->header('邀请设置');
            $content->description('设置邀请模板等信息');

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

            $content->header('编辑邀请');
            $content->description('编辑邀请模板信息');

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

            $content->header('创建邀请模板');
            $content->description('创建邀请模板信息');

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
        return Admin::grid(Invite::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('shareContent','分享内容');
            $grid->column('shareUrl','分享URL');
            $grid->column('images','图集')->image('', 60, 60);
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
        return Admin::form(Invite::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->textarea('shareContent','分享内容模板');
            $form->text('shareUrl','分享URL');
            $form->multipleImage('images','图集')->uniqueName()->removable();
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
