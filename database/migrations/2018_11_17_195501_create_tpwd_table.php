<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpwdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpwd', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tpwd')->comment('淘口令');
            $table->string('num_iid')->comment('淘宝产品ID');
            $table->string('userId')->comment('用户ID');
            $table->string('title')->comment('产品名称');
            $table->string('pict_url')->comment('产品图片');
            $table->string('price')->comment('价格');
            $table->string('coupon_info_price')->comment('优惠券面值');
            $table->string('commission_rate')->comment('佣金比例');
            $table->integer('click')->comment('点击次数');
            $table->integer('buy')->comment('购买次数');

            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `tpwd` comment'淘口令表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tpwd');
    }
}
