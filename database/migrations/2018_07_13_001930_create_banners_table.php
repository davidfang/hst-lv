<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banners', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('type', array('swiper','recommend','bestSelling'))->nullable()->default('swiper')->comment('类别');
			$table->string('title')->nullable()->comment('标题');
			$table->string('img_path')->nullable()->comment('图片路径');
			$table->string('img_base_url')->nullable()->comment('图片基本路径');
			$table->string('url')->nullable()->comment('链接地址');
			$table->enum('nav', array('SearchScreen','WebScreen','ChannelScreen','ClassifyListScreen','DetailScreen','RegisterScreen'))->nullable()->default('WebScreen')->comment('NAV类型');
			$table->string('params')->nullable()->default('{}')->comment('nav参数，使用json形式书写');
			$table->enum('status', array('1','0'))->nullable()->default('0')->comment('状态');
			$table->integer('created_at')->nullable()->default(0)->comment('创建时间');
			$table->integer('updated_at')->nullable()->default(0)->comment('更新时间');
			$table->integer('created_by')->unsigned()->nullable()->index('created_by_5')->comment('创建者');
			$table->integer('updated_by')->unsigned()->nullable()->index('updated_by_5')->comment('更新者');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banners');
	}

}
