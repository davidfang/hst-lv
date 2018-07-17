<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGoodsCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('goods_category', function(Blueprint $table)
		{
			$table->foreign('created_by', 'created_by_admin')->references('id')->on('admin_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('updated_by', 'updated_by_admin')->references('id')->on('admin_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('goods_category', function(Blueprint $table)
		{
			$table->dropForeign('created_by_admin');
			$table->dropForeign('updated_by_admin');
		});
	}

}
