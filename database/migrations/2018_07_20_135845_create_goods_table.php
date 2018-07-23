<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable()->comment('分类ID');
            $table->string('num_iid',20)->unique()->comment('商品ID');
            $table->string('title')->nullable()->comment('商品标题');
            $table->string('pict_url')->nullable()->comment('商品主图');
            $table->text('small_images')->nullable()->comment('商品小图列表');
            $table->decimal('reserve_price')->nullable()->comment('商品一口价格');
            $table->decimal('zk_final_price')->nullable()->comment('商品折扣价格');
            $table->smallInteger('user_type')->nullable()->default('1')->comment('卖家类型，0表示集市，1表示商城');
            $table->string('provcity')->nullable()->comment('宝贝所在地');
            $table->string('item_url',500)->nullable()->comment('商品地址');
            $table->string('click_url',500)->nullable()->comment('淘客地址');
            $table->string('nick')->nullable()->comment('卖家昵称');
            $table->string('seller_id',20)->nullable()->comment('卖家id');
            $table->unsignedInteger('volume')->nullable()->comment('30天销量');
            $table->unsignedInteger('tk_rate')->nullable()->comment('收入比例，举例，取值为20.00，表示比例20.00%');
            $table->decimal('zk_final_price_wap')->nullable()->comment('无线折扣价，即宝贝在无线上的实际售卖价格。');
            $table->string('shop_title')->nullable()->comment('店铺名称');
            $table->dateTime('event_start_time')->nullable()->comment('招商活动开始时间；如果该宝贝取自普通选品组，则取值为1970-01-01 00:00:00；');
            $table->dateTime('event_end_time')->nullable()->comment('招行活动的结束时间；如果该宝贝取自普通的选品组，则取值为1970-01-01 00:00:00');
            $table->smallInteger('type')->nullable()->comment('宝贝类型：1 普通商品； 2 鹊桥高佣金商品；3 定向招商商品；4 营销计划商品;');
            $table->smallInteger('status')->nullable()->default('1')->comment('宝贝状态，0失效，1有效；注：失效可能是宝贝已经下线或者是被处罚不能在进行推广');
            $table->string('category',20)->nullable()->comment('后台一级类目');
            $table->string('coupon_click_url',500)->nullable()->comment('商品优惠券推广链接');
            $table->dateTime('coupon_end_time')->nullable()->comment('优惠券结束时间');
            $table->string('coupon_info')->nullable()->comment('优惠券面额');
            $table->dateTime('coupon_start_time')->nullable()->comment('优惠券开始时间');
            $table->integer('coupon_total_count')->nullable()->comment('优惠券总量');
            $table->integer('coupon_remain_count')->nullable()->comment('优惠券剩余量');
            $table->text('detail')->nullable()->comment('产品详情');
            $table->string('from_site_url')->nullable()->comment('采集第三方网站');
            $table->smallInteger('coupon_status')->nullable()->comment('优惠券状态');
            $table->string('tpwd',500)->nullable()->comment('淘口令');
            $table->dateTime('tpwd_created_at')->nullable()->comment('淘口令生成时间');
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
        Schema::dropIfExists('goods');
    }
}
