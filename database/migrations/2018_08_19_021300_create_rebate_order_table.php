<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRebateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebate_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trade_parent_id')->comment('淘宝父订单号');
            $table->integer('trade_id')->comment('淘宝订单号');
            $table->integer('num_iid')->comment('商品ID');
            $table->string('item_title')->comment('商品标题');
            $table->integer('item_num')->comment('商品数量');
            $table->decimal('price')->comment('单价');
            $table->decimal('pay_price')->comment('实际支付金额');
            $table->string('seller_nick')->comment('卖家昵称');
            $table->string('seller_shop_title')->comment('卖家店铺名称');
            $table->decimal('commission')->comment('推广者获得的收入金额，对应联盟后台报表“预估收入”');
            $table->string('commission_rate')->comment('推广者获得的分成比率，对应联盟后台报表“分成比率”');
            $table->string('unid')->comment('推广者unid')->nullable();
            $table->dateTime('create_time')->comment('淘客订单创建时间');
            $table->dateTime('earning_time')->comment('淘客订单结算时间');
            $table->string('tk_status')->comment('淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `rebate_order` comment'返利订单表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rebate_order');
    }
}
