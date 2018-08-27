<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->decimal('amount')->default(0)->comment('总金额');
            $table->decimal('cash_balance')->default(0)->comment('可提现余额');
            $table->decimal('uncash_balance')->default(0)->comment('不可提现余额');
            $table->decimal('freeze_cash_balance')->default(0)->comment('可提现冻结余额');
            $table->decimal('freeze_uncash_balance')->default(0)->comment('不可提现冻结余额');
            $table->enum('status', array('1','0'))->default('1')->nullable()->comment('状态');
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `account` comment'用户账户表'"); // 表注
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
