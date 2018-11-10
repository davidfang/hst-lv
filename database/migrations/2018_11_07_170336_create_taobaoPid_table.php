<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaobaoPidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taobaoPid', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pid')->comment('pid');
            $table->string('name')->comment('名称');
            $table->string('siteId')->comment('siteId');
            $table->string('adzoneId')->comment('adzoneId');
            $table->string('userId')->comment('用户ID')->nullable();
            $table->string('taobaoId')->comment('淘宝账号ID');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `taobaoPid` comment'淘宝PID表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taobaoPid');
    }
}
