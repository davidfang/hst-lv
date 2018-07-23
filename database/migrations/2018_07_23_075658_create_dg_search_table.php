<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDgSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dg_search', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keyWord',150)->comment('搜索关键词')->nullable();
            $table->dateTime('coupon_start_time')->comment('优惠券开始时间')->nullable();
            $table->dateTime('coupon_end_time')->comment('优惠券结束时间')->nullable();
            $table->string('info_dxjh')->comment('定向计划信息')->nullable();
            $table->integer('tk_total_sales')->comment('淘客30天月推广量')->nullable();
            $table->decimal('tk_total_commi')->comment('月支出佣金')->nullable();
            $table->string('coupon_id')->comment('优惠券id')->nullable();
            $table->string('num_iid')->comment('宝贝id');
            $table->string('title')->comment('商品标题')->nullable();
            $table->string('pict_url')->comment('商品主图')->nullable();
            $table->string('small_images')->comment('商品小图列表')->nullable();
            $table->decimal('reserve_price')->comment('商品一口价格')->nullable();
            $table->decimal('zk_final_price')->comment('商品折扣价格')->nullable();
            $table->smallInteger('user_type')->comment('卖家类型，0表示集市，1表示商城')->nullable();
            $table->string('provcity')->comment('宝贝所在地')->nullable();
            $table->string('item_url')->comment('商品地址')->nullable();
            $table->string('include_mkt')->comment('是否包含营销计划')->nullable();
            $table->string('include_dxjh')->comment('是否包含定向计划')->nullable();
            $table->decimal('commission_rate')->comment('佣金比率')->nullable();
            $table->integer('volume')->comment('30天销量')->nullable();
            $table->string('seller_id')->comment('卖家id')->nullable();
            $table->integer('coupon_total_count')->comment('优惠券总量')->nullable();
            $table->integer('coupon_remain_count')->comment('优惠券剩余量')->nullable();
            $table->string('coupon_info')->comment('优惠券面额')->nullable();
            $table->string('commission_type')->comment('佣金类型  MKT表示营销计划，SP表示定向计划，COMMON表示通用计划')->nullable();
            $table->string('shop_title')->comment('店铺名称')->nullable();
            $table->string('shop_dsr')->comment('店铺dsr评分')->nullable();
            $table->string('coupon_share_url')->comment('券二合一页面链接')->nullable();
            $table->string('url',500)->comment('商品淘客链接')->nullable();
            $table->string('tpwd',500)->comment('淘口令')->nullable();
            $table->smallInteger('coupon_status')->nullable()->comment('优惠券状态');
            $table->dateTime('tpwd_created_at')->comment('淘口令生成时间')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dg_search');
    }
}
