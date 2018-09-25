<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('用户ID')->nullable();
            $table->text('content')->comment('为分享内容')->nullable();
            $table->string('img')->comment('为图片地址')->nullable();
            $table->string('url')->comment('为分享链接')->nullable();
            $table->string('title')->comment('为分享链接的标题')->nullable();
            $table->string('platform')->comment('为平台id');
            $table->string('type')->default('1')->comment('类型 1为圈子 2用户 3产品 ');
            $table->string('code')->comment('code为错误码，当为0时，标记成功');
            $table->string('message',150)->comment('message为错误信息');
            $table->string('other',255)->comment('其它信息，供后台操作使用，json形式');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `share` comment'用户分享记录表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share');
    }
}
