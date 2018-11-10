<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trade_parent_id')->comment('淘宝父订单号')->nullable();
            $table->string('trade_id',20)->comment('淘宝订单号');
            $table->string('num_iid',20)->comment('商品ID');
            $table->string('item_title')->comment('商品标题');
            $table->integer('item_num')->comment('商品数量');
            $table->decimal('price')->comment('单价');
            $table->decimal('pay_price')->comment('实际支付金额')->nullable();
            $table->string('seller_nick')->comment('卖家昵称');
            $table->string('seller_shop_title')->comment('卖家店铺名称');
            $table->decimal('commission')->comment('推广者获得的收入金额，对应联盟后台报表“预估收入”');
            $table->string('commission_rate')->comment('推广者获得的分成比率，对应联盟后台报表“分成比率”');
            $table->string('unid')->comment('推广者unid（已废弃）')->nullable();
            $table->dateTime('create_time')->comment('淘客订单创建时间');
            $table->dateTime('click_time')->comment('淘客订单点击时间')->nullable();
            $table->dateTime('earning_time')->comment('淘客订单结算时间')->nullable();
            $table->string('settlement_amount')->comment('结算金额')->nullable();
            $table->string('technical_service_fee_ratio')->comment('技术服务费比率')->nullable();

            $table->string('tk_status')->comment('淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功');
            $table->string('tk3rd_type')->comment('第三方服务来源，没有第三方服务，取值为“--”');
            $table->string('tk3rd_pub_id',20)->comment('第三方推广者ID')->nullable();
            $table->string('order_type')->comment('订单类型，如天猫，淘宝');
            $table->string('income_rate')->comment('收入比率，卖家设置佣金比率+平台补贴比率');
            $table->string('pub_share_pre_fee')->comment('效果预估，付款金额*(佣金比率+补贴比率)*分成比率');
            $table->string('subsidy_rate')->comment('补贴比率');
            $table->string('subsidy_type')->comment('补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4');
            $table->string('terminal_type')->comment('成交平台，PC:1，无线:2');
            $table->string('auction_category')->comment('类目名称');
            $table->string('site_id')->comment('来源媒体ID');
            $table->string('site_name')->comment('来源媒体名称');
            $table->string('adzone_id')->comment('广告位ID');
            $table->string('adzone_name')->comment('广告位名称');
            $table->string('alipay_total_price')->comment('付款金额');
            $table->string('total_commission_rate')->comment('佣金比率');
            $table->string('total_commission_fee')->comment('佣金金额');
            $table->string('subsidy_fee')->comment('补贴金额');
            $table->string('relation_id')->comment('渠道关系ID')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `order_history` comment'订单历史记录表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_hostory');
    }
}
