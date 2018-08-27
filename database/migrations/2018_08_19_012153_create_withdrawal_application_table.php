<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_application', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->decimal('amount')->comment('本次提现金额，单位分');

            $table->decimal('commission')->comment('手续费')->nullable();
            $table->string('remark_submit',50)->comment('提现申请备注')->nullable();
            $table->string('remark_audit',50)->comment('提现审核备注')->nullable();
            $table->string('out_trade_no',50)->comment('支付渠道')->nullable();
            $table->integer('bankcard_id')->comment('提现银行卡ID 支付宝');
            $table->enum('status',array('-1','0','1','2'))->comment('状态：-1-驳回、0-待审核、1-审核通过待打款、2-已打款');
            $table->integer('updated_by')->comment('操作者ID')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `withdrawal_application` comment'提现申请表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_application');
    }
}
