<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);
        $this->call(ArticleCategoryTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(SystemsSettingTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
    }
}
