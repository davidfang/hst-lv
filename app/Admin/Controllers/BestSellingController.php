<?php

namespace App\Admin\Controllers;

use App\Model\Banner;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BestSellingController extends Controller
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

            $content->header('首页弹出');
            $content->description('首页爆款热卖弹出');

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

            $content->header('编辑首页弹出');
            $content->description('首页爆款热卖弹出');

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

            $content->header('创建首页弹出');
            $content->description('首页爆款热卖弹出');

            $content->body($this->form());
        });
    }
    protected $navOptions = ['SearchScreen' => 'SearchScreen', 'WebScreen' => 'WebScreen', 'ChannelScreen' => 'ChannelScreen', 'DetailScreen' => 'DetailScreen'];
    protected $typeOptions = ['swiper' => 'swiper', 'recommend' => 'recommend'];
    protected $statusOptions = ['禁用', '启用'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Banner::class, function (Grid $grid) {
            $grid->model()->where('type', 'bestSelling');
            $grid->id('ID')->sortable();
            $grid->column('title', '标题');
//            $grid->column('type', '类别')->display(function ($k) {
//                $array = ['swiper' => 'swiper', 'recommend' => 'recommend'];
//                return $array[$k] ?: null;
//            });
            $grid->column('img_path', '图片')->image('', 30, 30);
            $grid->column('url', '链接地址');
            $grid->column('nav', 'App中链接目标')->display(function ($k) {
                $array = ['SearchScreen' => 'SearchScreen', 'WebScreen' => 'WebScreen', 'ChannelScreen' => 'ChannelScreen', 'DetailScreen' => 'DetailScreen'];
                return $array[$k] ?: null;
            });
            $grid->column('params','参数');
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $grid->column('status','状态')->switch($states);
            $grid->column('sort', '排序');
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
        return Admin::form(Banner::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title','标题');
            $form->hidden('type')->default('bestSelling');
//            $form->select('type','类别')->options(['swiper' => 'swiper', 'recommend' => 'recommend']);
            $form->image('img_path', '图标')->resize(350,100)->uniqueName();
            $form->text('url','链接')->rules('nullable');
            $form->select('nav','App中链接目标')->options(['SearchScreen' => 'SearchScreen', 'WebScreen' => 'WebScreen', 'ChannelScreen' => 'ChannelScreen','ClassifyListScreen'=>'ClassifyListScreen', 'DetailScreen' => 'DetailScreen']);
            $form->textarea('params','参数')->help('必须是json格式，此项必须要设置图片的宽高,例：{"channelId": 18508981,"width":100,"height":100}');
            $states = [
                'on'  => ['value' => '1', 'text' => '是', 'color' => 'primary'],
                'off' => ['value' => '0', 'text' => '否', 'color' => 'default'],
            ];
            $form->switch('status','状态')->states($states)->default(0);
            $form->display('created_by','创建人');
            $form->display('updated_by','修改人');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
