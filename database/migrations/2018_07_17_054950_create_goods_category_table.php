<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoodsCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_category', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('parent_id')->nullable()->default(0)->comment('父ID');
			$table->string('title')->nullable()->comment('分类');
			$table->string('img_path')->nullable();
			$table->string('img_base_url')->nullable();
			$table->smallInteger('status')->nullable()->default(0);
			$table->smallInteger('sort')->nullable()->default(0)->comment('排序');
			$table->integer('created_at')->nullable();
			$table->integer('updated_at')->nullable();
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->integer('updated_by')->unsigned()->index('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_category');
	}

}
