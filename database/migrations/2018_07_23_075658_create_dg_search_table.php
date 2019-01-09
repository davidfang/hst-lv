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
            $table->string('keyWord',500)->comment('搜索关键词')->nullable();
            $table->dateTime('coupon_start_time')->comment('优惠券开始时间')->nullable();
            $table->dateTime('coupon_end_time')->comment('优惠券结束时间')->nullable();
            $table->string('info_dxjh',500)->comment('定向计划信息')->nullable();
            $table->integer('tk_total_sales')->comment('淘客30天月推广量')->nullable();
            $table->decimal('tk_total_commi')->comment('月支出佣金')->nullable();
            $table->string('coupon_id',255)->comment('优惠券id')->nullable();
            $table->string('num_iid',255)->comment('宝贝id');
            $table->string('title',255)->comment('商品标题')->nullable();
            $table->string('pict_url',255)->comment('商品主图')->nullable();
            $table->string('small_images')->comment('商品小图列表')->nullable();
            $table->float('reserve_price')->comment('商品一口价格')->nullable();
            $table->float('zk_final_price')->comment('商品折扣价格')->nullable();
            $table->smallInteger('user_type')->comment('卖家类型，0表示集市，1表示商城')->nullable();
            $table->string('provcity',255)->comment('宝贝所在地')->nullable();
            $table->string('item_url',255)->comment('商品地址')->nullable();
            $table->string('include_mkt')->comment('是否包含营销计划')->nullable();
            $table->string('include_dxjh')->comment('是否包含定向计划')->nullable();
            $table->integer('commission_rate')->comment('佣金比率')->nullable();
            $table->float('commission_amount',10,2)->nullable()->comment('佣金金额');
            $table->integer('volume')->comment('30天销量')->nullable();
            $table->string('seller_id')->comment('卖家id')->nullable();
            $table->integer('coupon_total_count')->comment('优惠券总量')->nullable();
            $table->integer('coupon_remain_count')->comment('优惠券剩余量')->nullable();
            $table->string('coupon_info')->comment('优惠券面额')->nullable();
            $table->integer('coupon_info_price')->nullable()->comment('优惠券面额(数值)');
            $table->float('real_price',8,2)->nullable()->comment('真实价格');
            $table->string('commission_type')->comment('佣金类型  MKT表示营销计划，SP表示定向计划，COMMON表示通用计划')->nullable();
            $table->string('shop_title')->comment('店铺名称')->nullable();
            $table->string('shop_dsr')->comment('店铺dsr评分')->nullable();
            $table->string('coupon_share_url',600)->comment('券二合一页面链接')->nullable();
            $table->string('url',1024)->comment('商品淘客链接')->nullable();
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
