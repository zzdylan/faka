<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 0,
                'title' => '商品分类',
                'icon' => 'fa-bars',
                'uri' => 'goods/categories',
                'permission' => NULL,
                'created_at' => '2018-12-30 22:45:12',
                'updated_at' => '2018-12-30 22:46:33',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 0,
                'title' => '商品',
                'icon' => 'fa-bars',
                'uri' => 'goods',
                'permission' => NULL,
                'created_at' => '2018-12-30 23:35:35',
                'updated_at' => '2018-12-30 23:35:35',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 0,
                'title' => '卡密',
                'icon' => 'fa-bars',
                'uri' => 'cards',
                'permission' => NULL,
                'created_at' => '2018-12-31 10:26:38',
                'updated_at' => '2018-12-31 10:26:38',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 0,
                'title' => '订单',
                'icon' => 'fa-bars',
                'uri' => 'orders',
                'permission' => NULL,
                'created_at' => '2019-01-01 22:31:33',
                'updated_at' => '2019-01-01 22:31:33',
            ),
        ));
        
        
    }
}