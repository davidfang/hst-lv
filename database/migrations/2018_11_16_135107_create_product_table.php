<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('my_category_id')->nullable()->comment('系统分类ID');

            $table->integer('category_id')->nullable()->comment('叶子类目id');
            $table->string('num_iid',20)->unique()->comment('商品ID');
            $table->string('title')->nullable()->comment('商品标题');
            $table->string('pict_url')->nullable()->comment('商品主图');
            $table->text('small_images')->nullable()->comment('商品小图列表');
            $table->decimal('reserve_price')->nullable()->comment('商品一口价格');
            $table->decimal('zk_final_price')->nullable()->comment('商品折扣价格');
            $table->smallInteger('user_type')->nullable()->default('1')->comment('卖家类型，0表示集市，1表示商城');
            $table->string('provcity')->nullable()->comment('宝贝所在地');
            $table->string('item_url',500)->nullable()->comment('商品地址');
            $table->string('seller_id',20)->nullable()->comment('卖家id');
            $table->unsignedInteger('volume')->nullable()->comment('30天销量');
            $table->string('shop_title')->nullable()->comment('店铺名称');
            $table->dateTime('coupon_end_time')->nullable()->comment('优惠券结束时间');
            $table->string('coupon_info')->nullable()->comment('优惠券面额');
            $table->dateTime('coupon_start_time')->nullable()->comment('优惠券开始时间');
            $table->integer('coupon_total_count')->nullable()->comment('优惠券总量');
            $table->integer('coupon_remain_count')->nullable()->comment('优惠券剩余量');




            $table->string('info_dxjh',1024)->nullable()->comment('定向计划信息');
            $table->string('tk_total_sales')->nullable()->comment('淘客30天月推广量');
            $table->string('tk_total_commi')->nullable()->comment('月支出佣金');
            $table->string('coupon_id')->nullable()->comment('优惠券id');
            $table->string('include_mkt')->nullable()->comment('是否包含营销计划');
            $table->string('include_dxjh')->nullable()->comment('是否包含定向计划');
            $table->string('commission_rate')->nullable()->comment('佣金比率');
            $table->string('commission_type')->nullable()->comment('佣金类型 MKT表示营销计划，SP表示定向计划，COMMON表示通用计划');
            $table->string('shop_dsr')->nullable()->comment('店铺dsr评分');
            $table->string('coupon_share_url',1024)->nullable()->comment('券二合一页面链接');
            $table->string('url',1024)->nullable()->comment('商品淘客链接');
            $table->string('level_one_category_name')->nullable()->comment('一级类目名称');
            $table->string('level_one_category_id')->nullable()->comment('一级类目ID');
            $table->string('category_name')->nullable()->comment('叶子类目名称');
            $table->string('short_title')->nullable()->comment('商品短标题');
            $table->string('white_image')->nullable()->comment('商品白底图');
            $table->string('oetime')->nullable()->comment('拼团：结束时间');
            $table->string('ostime')->nullable()->comment('拼团：开始时间');
            $table->string('jdd_num')->nullable()->comment('拼团：几人团');
            $table->string('jdd_price')->nullable()->comment('拼团：拼成价，单位元');
            $table->string('uv_sum_pre_sale')->nullable()->comment('预售数量');



            $table->string('coupon_info_price')->nullable()->comment('优惠券面额(数值)');
            $table->text('detail')->nullable()->comment('产品详情');
            $table->string('tpwd',500)->nullable()->comment('淘口令');
            $table->dateTime('tpwd_created_at')->nullable()->comment('淘口令生成时间');


            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `product` comment'产品表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
