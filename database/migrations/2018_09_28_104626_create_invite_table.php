<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shareContent')->comment('分享内容模板，中间包含inviteCode');
            $table->string('shareUrl')->comment('分享URL');
            $table->string('images')->comment('分享图片模板(多张)');
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->enum('status', array('1','0'))->nullable()->default('0')->comment('状态');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `invite` comment'邀请设置表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invite');
    }
}
