<?php

use Illuminate\Database\Seeder;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = array(
            array('id' => '1', 'name' => 'All permission', 'slug' => '*', 'http_method' => '', 'http_path' => '*', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'name' => 'Dashboard', 'slug' => 'dashboard', 'http_method' => 'GET', 'http_path' => '/', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'name' => 'Login', 'slug' => 'auth.login', 'http_method' => '', 'http_path' => '/auth/login
/auth/logout', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'name' => 'User setting', 'slug' => 'auth.setting', 'http_method' => 'GET,PUT', 'http_path' => '/auth/setting', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'name' => 'Auth management', 'slug' => 'auth.management', 'http_method' => '', 'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'name' => 'Admin helpers', 'slug' => 'ext.helpers', 'http_method' => NULL, 'http_path' => '/helpers/*', 'created_at' => '2018-12-21 22:37:26', 'updated_at' => '2018-12-21 22:37:26')
        );
        \DB::table('admin_permissions')->delete();
        \DB::table('admin_permissions')->insert($admin_permissions);
    }
}
