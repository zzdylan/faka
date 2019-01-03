<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$47vOYpgysvKcYNf1EY/GYeOKfbsU6N33zPWWfHHOFGh6/WuYCvEL6',
                'name' => 'admin',
                'avatar' => NULL,
                'remember_token' => NULL,
                'created_at' => '2019-01-03 20:25:14',
                'updated_at' => '2019-01-03 20:25:14',
            ),
        ));
        
        
    }
}