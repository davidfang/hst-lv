<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',1024)->comment('slugen')->nullable();
            $table->string('title',512)->comment('标题');
            $table->text('body')->comment('介绍')->nullable();
            $table->string('parent_id')->comment('上级分类id')->nullable()->default(0);
            $table->string('view')->comment('模板名称')->nullable();
            $table->unsignedSmallInteger('sort')->comment('排序')->nullable();
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->enum('status', array('1','0'))->nullable()->default('0')->comment('状态');
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
        Schema::dropIfExists('article_category');
    }
}
