<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemsSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->comment('键');
            $table->string('val')->comment('值');
            $table->string('remark')->comment('备注');
            $table->string('status')->comment('状态')->nullable();
            $table->integer('created_by')->comment('创建者')->nullable();
            $table->integer('updated_by')->comment('修改者')->nullable();
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
        Schema::dropIfExists('systems_setting');
    }
}
