<?php

use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article_category')->delete();
        
        \DB::table('article_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => '新手攻略',
                'title' => '新手攻略',
                'body' => '关于使用的方法，推广的方法，佣金获得等',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => '1',
                'created_at' => '2018-08-07 09:58:02',
                'updated_at' => '2018-08-12 22:59:27',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => '常见问题',
                'title' => '常见问题',
                'body' => '常见问题',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'status' => '1',
                'created_at' => '2018-08-07 10:00:14',
                'updated_at' => '2018-08-07 10:00:14',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'slug' => '联系客服',
                'title' => '联系客服',
                'body' => '联系客服',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'status' => '1',
                'created_at' => '2018-08-07 10:01:01',
                'updated_at' => '2018-08-07 10:01:01',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'slug' => '官方公告',
                'title' => '官方公告',
                'body' => '官方公告',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'status' => '1',
                'created_at' => '2018-08-07 10:01:28',
                'updated_at' => '2018-08-07 10:01:28',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'slug' => '朋友圈',
                'title' => '朋友圈--宣传材料',
                'body' => '朋友圈，转发，分享材料',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => '1',
                'created_at' => '2018-08-10 02:56:26',
                'updated_at' => '2018-08-13 09:36:09',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'slug' => '朋友圈',
                'title' => '朋友圈--每日爆款',
                'body' => '朋友圈--每日爆款',
                'parent_id' => '0',
                'sort' => 0,
                'view' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'status' => '1',
                'created_at' => '2018-08-13 09:37:10',
                'updated_at' => '2018-08-13 09:37:10',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}