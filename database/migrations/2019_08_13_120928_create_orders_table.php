<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('trade_no')->comment('订单号');
			$table->string('name')->comment('订单名称');
			$table->integer('goods_id')->comment('商品id');
			$table->string('goods_name')->comment('商品名称');
			$table->decimal('unit_price')->comment('商品单价');
			$table->integer('count')->comment('购买数量');
			$table->decimal('total_price')->comment('订单总价');
			$table->decimal('real_total_price')->nullable()->comment('订单真实总价');
			$table->string('pay_account')->nullable()->comment('充值账号');
			$table->string('email')->nullable()->comment('邮箱');
			$table->boolean('type')->comment('订单类型   1手工订单 2自动发卡');
			$table->string('out_trade_no')->nullable()->comment('外部订单号');
			$table->boolean('pay_type')->nullable()->comment('支付方式');
			$table->string('password')->nullable()->comment('查询密码');
			$table->string('more_input_value')->nullable()->comment('更多表单值');
			$table->boolean('status')->default(0)->comment('0未支付 1已支付,正在处理中 2已过期 3处理成功 4处理失败');
			$table->dateTime('pay_time')->nullable()->comment('支付时间');
			$table->string('ip')->nullable()->comment('客户端ip');
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
		Schema::drop('orders');
	}

}
