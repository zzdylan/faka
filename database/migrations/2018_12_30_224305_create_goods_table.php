<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->comment('商品分类id');
            $table->string('name')->comment('商品名称');
            $table->text('introduce')->nullable()->comment('商品介绍');
            $table->decimal('price')->comment('商品价格');
            $table->tinyInteger('type')->comment('商品类型   1手工商品 2自动发卡');
            $table->unsignedInteger('sold_count')->default(0)->comment('销量');
            $table->unsignedInteger('stock')->default(0)->comment('库存');
            $table->tinyInteger('status')->default(1)->comment('商品上架状态 0下架  1上架');
            $table->integer('sort')->comment('商品排序');
            $table->string('first_input')->comment('第一个输入框标题');
            $table->string('more_input')->nullable()->comment('更多输入框 逗号隔开');
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
        Schema::dropIfExists('goods');
    }
}
