<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyLog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_iid')->comment('淘宝产品ID');
            $table->string('userId')->comment('用户ID');
            $table->string('title')->comment('产品名称');
            $table->string('pict_url')->comment('产品图片');
            $table->float('price')->comment('价格');
            $table->float('coupon_info_price')->comment('优惠券面值');
            $table->float('commission_rate')->comment('佣金比例');
            $table->float('commission_amount',10,2)->comment('佣金金额');
            $table->string('ip')->comment('ip')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `buyLog` comment'产品购买记录表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyLog');
    }
}
