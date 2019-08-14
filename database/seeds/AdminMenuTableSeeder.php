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
                'title' => '主页',
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
                'title' => '后台管理',
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
                'title' => '管理员',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2019-08-13 11:54:16',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => '角色',
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
                'title' => '权限',
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
                'title' => '菜单',
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
                'title' => '日志',
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
                'order' => 9,
                'title' => '商品分类',
                'icon' => 'fa-bars',
                'uri' => 'goods/categories',
                'permission' => NULL,
                'created_at' => '2018-12-30 22:45:12',
                'updated_at' => '2019-01-10 17:22:45',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 10,
                'title' => '商品',
                'icon' => 'fa-bars',
                'uri' => 'goods',
                'permission' => NULL,
                'created_at' => '2018-12-30 23:35:35',
                'updated_at' => '2019-01-10 17:22:45',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 11,
                'title' => '卡密',
                'icon' => 'fa-bars',
                'uri' => 'cards',
                'permission' => NULL,
                'created_at' => '2018-12-31 10:26:38',
                'updated_at' => '2019-01-10 17:22:45',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 12,
                'title' => '订单',
                'icon' => 'fa-bars',
                'uri' => 'orders',
                'permission' => NULL,
                'created_at' => '2019-01-01 22:31:33',
                'updated_at' => '2019-01-10 17:22:45',
            ),
            11 => 
            array (
                'id' => 22,
                'parent_id' => 0,
                'order' => 13,
                'title' => '配置',
                'icon' => 'fa-toggle-on',
                'uri' => 'configx/edit',
                'permission' => NULL,
                'created_at' => '2019-08-13 11:22:10',
                'updated_at' => '2019-08-13 11:54:32',
            ),
            12 => 
            array (
                'id' => 23,
                'parent_id' => 0,
                'order' => 0,
                'title' => '邮件模板',
                'icon' => 'fa-commenting-o',
                'uri' => 'email-templates',
                'permission' => NULL,
                'created_at' => '2019-08-13 18:29:17',
                'updated_at' => '2019-08-13 18:29:17',
            ),
        ));
        
        
    }
}