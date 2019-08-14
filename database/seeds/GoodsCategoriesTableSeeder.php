<?php

use Illuminate\Database\Seeder;

class GoodsCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('goods_categories')->delete();
        
        \DB::table('goods_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '测试分类',
                'sort' => 0,
                'status' => 1,
                'created_at' => '2019-08-13 12:02:07',
                'updated_at' => '2019-08-13 12:02:07',
            ),
        ));
        
        
    }
}