<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',1024)->comment('slugen')->nullable();
            $table->string('title',512)->comment('标题');
            $table->text('body')->comment('介绍')->nullable();
            $table->integer('category_id')->comment('分类id');
            $table->string('view')->comment('模板名称')->nullable();
            $table->string('thumbnail')->comment('缩略图')->nullable();
            $table->string('images')->comment('图集')->nullable();
            $table->unsignedSmallInteger('sort')->comment('排序')->nullable();
            $table->enum('status', array('1','0'))->nullable()->default('0')->comment('状态');
            $table->integer('click')->comment('点击次数')->nullable()->default(0);
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `article` comment'文章表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
