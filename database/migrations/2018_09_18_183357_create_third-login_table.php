<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThirdLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_login', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->comment('用户ID')->nullable();

            $table->string('uid')->comment('三方的uid');
            $table->string('platform')->default('2')->comment('三方平台 默认为2微信（平台参见友盟）');
            $table->string('screen_name')->comment('用户名');
            $table->string('iconurl')->comment('头像');
            $table->longText('accessToken')->comment('accessToken');
            $table->longText('refreshToken')->comment('refreshToken');
            $table->string('gender')->comment('性别');
            $table->string('unionid')->comment('unionid');
            $table->string('openid')->comment('openid');
            $table->string('expires_in')->comment('过期时间')->nullable();
            $table->text('other')->comment('其它');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `third_login` comment'三方登录授权表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('third-login');
    }
}
