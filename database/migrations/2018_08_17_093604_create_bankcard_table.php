<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankcard', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('channel',20)->comment('渠道');
            $table->string('bank_name',50)->comment('银行开户支行名称')->nullable();
            $table->string('name',10)->comment('银行卡持卡人姓名');
            $table->string('bank_card_no',20)->comment('银行卡卡号');
            $table->enum('status', array('1','0'))->default('1')->nullable()->comment('状态');
            $table->integer('updated_by')->comment('修改者')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `bankcard` comment'银行卡表'"); // 表注
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bankcard');
    }
}
