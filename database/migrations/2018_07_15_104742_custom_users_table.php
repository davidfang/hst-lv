<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('name',30)->nullable()->comment('名字')->change();
            $table->string('nickname',30)->nullable()->comment('用户昵称');
            $table->string('email',50)->nullable()->comment('邮箱')->change();
            $table->string('mobile',11)->unique()->comment('手机号');
            $table->string('password',100)->nullable()->comment('用户的密码')->change();
            $table->unsignedSmallInteger('age')->default(0)->comment('年龄');
            $table->enum('gender',['0','1','2'])->default('0')->comment("性别('男','女','未设置')");
            $table->string('avatar', 100)->nullable()->comment('头像');
            $table->enum('grade',['0','1','2'])->default('0')->comment("会员等级('VIP会员','超级会员','运营商')");
            $table->enum('status',['0','1','2'])->default('1')->comment("状态('禁用','正常','异常')");
            $table->integer('parent_id')->nullable()->comment('父ID')->default(0);
            $table->integer('grandpa_id')->nullable()->comment('爷ID')->default(0);
            $table->integer('operator_id')->nullable()->comment('运营商ID')->default(0);
            $table->string('invitation_code',10)->nullable()->comment('邀请码');
            $table->ipAddress('ip');
            $table->ipAddress('last_login_ip')->comment('最后一次登录ip');
            $table->timestamp('last_login_time')->nullable()->comment('最后一次登录时间');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('name',30)->nullable()->comment('名字')->change();
            $table->string('nickname',30)->default('未取昵称')->comment('用户昵称');
            $table->string('email',50)->nullable()->comment('邮箱')->change();
            $table->string('mobile',11)->unique()->comment('手机号');
            $table->string('password',100)->comment('用户的密码')->change();
            $table->enum('gender',['男','女','未设置'])->default('未设置')->comment('性别');
            $table->string('avatar', 100)->nullable()->comment('头像');
            $table->enum('grade',['VIP会员','超级会员','运营商'])->default('VIP会员')->comment('会员等级');
            $table->enum('status',['正常','禁用','异常'])->default('正常');
            $table->integer('parent_id')->nullable()->comment('父ID');
            $table->string('invitation_code',10)->nullable()->comment('邀请码');
            $table->timestamp('last_login_time')->nullable()->comment('最后一次登录时间');

        });
    }
}
