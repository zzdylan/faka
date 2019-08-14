<?php

use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_templates')->delete();
        
        \DB::table('email_templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '测试模板',
                'content_blade' => '<p></p><p></p><h1>{{$order-&gt;trade_no}}</h1><p><b>​</b>​<br></p>',
                'created_at' => '2019-08-13 18:29:40',
                'updated_at' => '2019-08-13 19:50:32',
            ),
        ));
        
        
    }
}