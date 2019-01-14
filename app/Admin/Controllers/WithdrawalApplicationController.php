<?php

namespace App\Admin\Controllers;

use App\Model\WithdrawalApplication;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WithdrawalApplicationController extends Controller
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

            $content->header('提现申请');
            $content->description('提现申请');

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
        return Admin::grid(WithdrawalApplication::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('userInfo.name','用户姓名');
            $grid->column('amount','本次提现金额，单位分');

            $grid->column('commission','手续费');
            $grid->column('remark_submit','提现申请备注');
            $grid->column('remark_audit','提现审核备注');
            $grid->column('out_trade_no','支付渠道');
            $grid->column('bankcard_id','提现银行卡ID 支付宝');

            $grid->column('status','状态')->editable('select',array('-1'=>'驳回','0'=>'待审核','1'=>'审核通过待打款','2'=>'已打款'));//：-1-驳回、0-待审核、1-审核通过待打款、2-已打款
            $grid->column('updatedBy.username')->comment('修改者');

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
        return Admin::form(WithdrawalApplication::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
