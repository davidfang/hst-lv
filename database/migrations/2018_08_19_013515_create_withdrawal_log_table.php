<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('withdrawal_application_id')->comment('提现申请ID');
            $table->integer('user_id')->comment('用户ID');
            $table->integer('admin_id')->comment('后台操作者ID');
            $table->decimal('amount')->comment('提现金额');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `withdrawal_log` comment'提现日志表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_log');
    }
}
