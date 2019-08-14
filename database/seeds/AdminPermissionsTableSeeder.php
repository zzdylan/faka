<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'All permission',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Login',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'User setting',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Auth management',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Admin helpers',
                'slug' => 'ext.helpers',
                'http_method' => NULL,
                'http_path' => '/helpers/*',
                'created_at' => '2018-12-21 22:37:26',
                'updated_at' => '2018-12-21 22:37:26',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Admin Config',
                'slug' => 'ext.config',
                'http_method' => NULL,
                'http_path' => '/config*',
                'created_at' => '2019-01-10 15:33:42',
                'updated_at' => '2019-01-10 15:33:42',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'Admin Configx',
                'slug' => 'ext.configx',
                'http_method' => NULL,
                'http_path' => '/configx/*',
                'created_at' => '2019-08-13 11:22:10',
                'updated_at' => '2019-08-13 11:22:10',
            ),
        ));
        
        
    }
}