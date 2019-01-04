<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorySpiderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorySpider', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parentId')->comment('上级分类');
            $table->string("categoryCode")->comment('分类Code');
            $table->string("name")->comment('分类名称');
            $table->string("linkType")->comment('linkType')->nullable();
            $table->string("linkParam")->comment('linkParam')->nullable();
            $table->string("pic")->comment('分类图片');
            $table->string("queryTag")->comment('分类tag');
            $table->string("showSubTotal")->comment('showSubTotal')->nullable();
            $table->string("my_category_id")->comment('本系统分类id');
            $table->string("my_pic")->comment('本系统分类图片');

            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `categorySpider` comment'分类采集表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorySpider');
    }
}
