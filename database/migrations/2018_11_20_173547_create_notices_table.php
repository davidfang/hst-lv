<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('url')->nullable()->comment('链接地址');
            $table->string('body')->nullable()->comment('内容');
            $table->enum('status', array('1','0'))->nullable()->default('0')->comment('状态');
            $table->integer('click')->nullable()->default('0')->comment('点击数');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->nullable()->comment('创建者');
            $table->integer('updated_by')->unsigned()->nullable()->comment('更新者');
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `notices` comment'广播消息表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
