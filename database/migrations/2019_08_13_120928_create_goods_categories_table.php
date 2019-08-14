<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoodsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->comment('商品分类名称');
			$table->integer('sort')->comment('商品分类排序');
			$table->boolean('status')->default(1)->comment('状态');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_categories');
	}

}
