<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->decimal('amount')->default(0)->comment('发生金额');
            $table->decimal('before_amount')->default(0)->comment('操作前总金额');
            $table->decimal('after_amount')->default(0)->comment('操作后总金额');
            $table->decimal('before_cash_balance')->comment('操作前可提现余额，单位分');
            $table->decimal('after_cash_balance')->comment('操作后可提现余额，单位分');
            $table->decimal('before_uncash_balance')->default(0)->comment('操作前不可提现余额');
            $table->decimal('after_uncash_balance')->default(0)->comment('操作后不可提现余额');
            $table->decimal('before_freeze_cash_balance')->comment('操作前可提现冻结余额');
            $table->decimal('after_freeze_cash_balance')->comment('操作后可提现冻结余额');
            $table->decimal('before_freeze_uncash_balance')->default(0)->comment('操作前不可提现冻结余额');
            $table->decimal('after_freeze_uncash_balance')->default(0)->comment('操作后不可提现冻结余额');

            $table->string('change_type')->comment('类型，1 订单 2 订单收货 3 订单退货 4 上月结账 5 提现 6 提现付款 7 内部调账');
            $table->string('ref_sn')->comment('关联流水ID，change_type对应不同表，订单表，提现申请表，付款等');
            $table->string('remark',100)->comment('交易备注');


            $table->integer('updated_by')->comment('操作者ID')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `account_log` comment'用户账户日志表'"); // 表注
        /**
         * 总金额 = 可用金额 + 不可用金额
         * 可用金额 = 可提现余额 + 不可提现余额
         * 不可用金额 = 可提现冻结余额 + 不可提现冻结余额
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
