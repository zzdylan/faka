<?php

use Illuminate\Database\Seeder;

class AdminRoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_role_menu')->delete();
        $data = [];
        foreach(range(1,11) as $menuId){
            $data[] = [
                'role_id' => 1,
                'menu_id' => $menuId
            ];
        }
        \DB::table('admin_role_menu')->insert($data);
    }
}
