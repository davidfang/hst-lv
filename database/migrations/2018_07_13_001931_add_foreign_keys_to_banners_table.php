<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('banners', function(Blueprint $table)
		{
			$table->foreign('created_by', 'banner_created_by')->references('id')->on('admin_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('updated_by', 'banner_updated_by')->references('id')->on('admin_users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('banners', function(Blueprint $table)
		{
			$table->dropForeign('banner_created_by');
			$table->dropForeign('banner_updated_by');
		});
	}

}
