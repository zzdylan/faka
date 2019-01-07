<?php

use Illuminate\Database\Seeder;

class AdminRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_role_permissions')->delete();

        \DB::table('admin_role_permissions')->insert(array (
            0 =>
                array (
                    'role_id' => 1,
                    'permission_id' => 1,
                ),
        ));
    }
}
