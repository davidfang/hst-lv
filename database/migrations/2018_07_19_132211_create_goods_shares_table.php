<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoodsSharesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_shares', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 191)->default('');
			$table->string('title', 191)->default('');
			$table->integer('category_id')->default(0);
			$table->string('from_site', 30)->default('');
			$table->decimal('price', 10, 1)->default(0.0);
			$table->string('click_url', 500)->default('');
			$table->text('detail', 65535)->nullable();
			$table->string('keywords', 191)->nullable()->default('');
			$table->string('description', 191)->nullable()->default('');
			$table->string('original_id', 20)->default('0');
			$table->string('cover', 191)->nullable()->default('');
			$table->text('pictures', 65535)->nullable();
			$table->string('item_url', 191)->default('');
			$table->decimal('subject', 3)->nullable()->default(0.00);
			$table->integer('subject_count')->nullable()->default(0);
			$table->string('coupon_click_url', 500)->nullable()->default('');
			$table->date('coupon_start_time')->nullable();
			$table->date('coupon_end_time')->nullable();
			$table->decimal('coupon_amount', 10)->default(0.00);
			$table->decimal('coupon_start_fee', 10)->default(0.00);
			$table->integer('coupon_remain_count')->default(0);
			$table->boolean('coupon_status')->default(0);
			$table->integer('view')->default(0);
			$table->integer('volume')->default(0);
			$table->integer('channel_id')->default(0);
			$table->boolean('status')->default(1);
			$table->dateTime('tpwd_create_time')->nullable();
			$table->string('tpwd', 20)->nullable()->default('');
			$table->decimal('coupon_price', 10, 1)->default(0.0);
			$table->boolean('is_recommend')->default(0);
			$table->string('coupon_info', 60)->nullable()->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_shares');
	}

}
