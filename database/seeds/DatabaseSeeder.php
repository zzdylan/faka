<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(AdminRoleUsersTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(AdminRoleMenuSeeder::class);
        $this->call(AdminPermissionsSeeder::class);
        $this->call(AdminRolePermissionsSeeder::class);
    }
}
