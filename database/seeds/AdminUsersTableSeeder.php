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
                'password' => '$2y$10$vq6MNVmnfmoP3XUGZMH2TuSfVo4LxMZYtpD8.M5bkgTpmsJ1zHmVC',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => 'YMlztjQwUpQUXoyU1nm818793Fi3LhhcmmZuU8eiBflxQ314xWo9PUlfUgyZ',
                'created_at' => '2018-07-24 02:33:24',
                'updated_at' => '2018-07-24 07:07:02',
            ),
        ));
        
        
    }
}