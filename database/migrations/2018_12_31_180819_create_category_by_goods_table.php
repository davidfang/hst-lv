<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryByGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_by_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoryName')->comment('分类名称');
            $table->string('categoryId')->comment('分类ID');
            $table->string('goodsId',1024)->comment('产品IDs');
            $table->string('date')->comment('日期');
            $table->string('channel')->comment('采集渠道');
            $table->string('status')->default('false')->comment('采集状态');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `category_by_goods` comment'根据产品ID进行分类采集表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_by_goods');
    }
}
