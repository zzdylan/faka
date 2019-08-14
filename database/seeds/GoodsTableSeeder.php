<?php

use Illuminate\Database\Seeder;

class GoodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('goods')->delete();
        
        \DB::table('goods')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'name' => '测试商品',
                'introduce' => '<p></p><p>商品介绍</p>',
                'price' => '0.01',
                'type' => 1,
                'sold_count' => 0,
                'stock' => 999,
                'status' => 1,
                'sort' => 0,
                'first_input' => '学号',
                'more_input' => '密码',
                'created_at' => '2019-08-13 12:04:08',
                'updated_at' => '2019-08-13 12:04:21',
            ),
        ));
        
        
    }
}