<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_version', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('APP名称');
            $table->string('platform')->comment('APP平台');
            $table->string('version')->comment('版本号');
            $table->string('description',1024)->comment('版本说明');
            $table->string('status')->comment('状态');
            $table->string('appUrl',1024)->comment('更新地址');
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `app_version` comment'APP版本更新表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appVersion');
    }
}
