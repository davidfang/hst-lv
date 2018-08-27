<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refund', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('commission')->comment('返利总金额');
            $table->integer('order')->comment('订单数量');
            $table->string('type')->comment('类别 "自己消费" "直属粉丝" "推荐粉丝" "活动 "');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `order_refund` comment'订单归帐表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_refund');
    }
}
