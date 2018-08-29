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
                'title' => 'Index',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 7,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => '',
                'created_at' => '2018-07-12 06:52:58',
                'updated_at' => '2018-07-12 06:52:58',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 8,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'created_at' => '2018-07-12 06:52:58',
                'updated_at' => '2018-07-12 06:52:58',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 9,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'created_at' => '2018-07-12 06:52:58',
                'updated_at' => '2018-07-12 06:52:58',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 10,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'created_at' => '2018-07-12 06:52:58',
                'updated_at' => '2018-07-12 06:52:58',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 8,
                'order' => 11,
                'title' => 'Routes',
                'icon' => 'fa-list-alt',
                'uri' => 'helpers/routes',
                'created_at' => '2018-07-12 06:52:58',
                'updated_at' => '2018-07-12 06:52:58',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 12,
                'title' => 'Media manager',
                'icon' => 'fa-file',
                'uri' => 'media',
                'created_at' => '2018-07-12 06:56:28',
                'updated_at' => '2018-07-12 06:56:28',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 0,
                'order' => 13,
                'title' => 'Api tester',
                'icon' => 'fa-sliders',
                'uri' => 'api-tester',
                'created_at' => '2018-07-12 07:05:29',
                'updated_at' => '2018-07-12 07:05:29',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'order' => 14,
                'title' => 'Scheduling',
                'icon' => 'fa-clock-o',
                'uri' => 'scheduling',
                'created_at' => '2018-07-12 07:13:43',
                'updated_at' => '2018-07-12 07:13:43',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 0,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => 'user',
                'created_at' => '2018-07-17 09:58:26',
                'updated_at' => '2018-07-17 09:58:26',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 0,
                'order' => 0,
                'title' => '运营管理',
                'icon' => 'fa-medium',
                'uri' => NULL,
                'created_at' => '2018-07-18 01:47:46',
                'updated_at' => '2018-07-18 01:47:46',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 17,
                'order' => 0,
                'title' => '产品分类',
                'icon' => 'fa-cubes',
                'uri' => 'goods-category',
                'created_at' => '2018-07-18 01:49:27',
                'updated_at' => '2018-07-18 01:49:27',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 17,
                'order' => 0,
                'title' => 'banner广告位管理',
                'icon' => 'fa-bold',
                'uri' => 'banner',
                'created_at' => '2018-07-18 01:50:13',
                'updated_at' => '2018-07-18 01:50:13',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 17,
                'order' => 0,
                'title' => '淘宝产品库更新',
                'icon' => 'fa-retweet',
                'uri' => 'taobao/selection',
                'created_at' => '2018-07-19 16:20:03',
                'updated_at' => '2018-07-19 16:20:03',
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 17,
                'order' => 0,
                'title' => '产品管理',
                'icon' => 'fa-product-hunt',
                'uri' => 'goods-taobao',
                'created_at' => '2018-07-20 03:39:28',
                'updated_at' => '2018-07-23 07:07:43',
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 17,
                'order' => 0,
                'title' => '搜索记录',
                'icon' => 'fa-binoculars',
                'uri' => 'search-log',
                'created_at' => '2018-07-23 10:28:20',
                'updated_at' => '2018-07-23 10:28:20',
            ),
            22 => 
            array (
                'id' => 28,
                'parent_id' => 17,
                'order' => 0,
                'title' => '轮播图管理',
                'icon' => 'fa-forumbee',
                'uri' => 'swiper',
                'created_at' => '2018-08-13 04:06:28',
                'updated_at' => '2018-08-13 04:13:25',
            ),
            23 => 
            array (
                'id' => 29,
                'parent_id' => 0,
                'order' => 0,
                'title' => '文章公告管理',
                'icon' => 'fa-chrome',
                'uri' => NULL,
                'created_at' => '2018-08-13 04:08:50',
                'updated_at' => '2018-08-13 04:08:50',
            ),
            24 => 
            array (
                'id' => 30,
                'parent_id' => 29,
                'order' => 0,
                'title' => '文章分类',
                'icon' => 'fa-suitcase',
                'uri' => 'article-category',
                'created_at' => '2018-08-13 04:10:50',
                'updated_at' => '2018-08-13 04:10:50',
            ),
            25 => 
            array (
                'id' => 31,
                'parent_id' => 29,
                'order' => 0,
                'title' => '文章管理',
                'icon' => 'fa-file-word-o',
                'uri' => 'article',
                'created_at' => '2018-08-13 04:11:23',
                'updated_at' => '2018-08-13 04:11:23',
            ),
            26 => 
            array (
                'id' => 32,
                'parent_id' => 17,
                'order' => 0,
                'title' => '用户反馈',
                'icon' => 'fa-feed',
                'uri' => 'feed-back',
                'created_at' => '2018-08-13 04:29:12',
                'updated_at' => '2018-08-13 04:30:38',
            ),
            27 => 
            array (
                'id' => 33,
                'parent_id' => 0,
                'order' => 0,
                'title' => '系统管理',
                'icon' => 'fa-cubes',
                'uri' => NULL,
                'created_at' => '2018-08-28 07:03:50',
                'updated_at' => '2018-08-28 07:03:50',
            ),
            28 => 
            array (
                'id' => 34,
                'parent_id' => 33,
                'order' => 0,
                'title' => '系统设置',
                'icon' => 'fa-crosshairs',
                'uri' => 'app-set',
                'created_at' => '2018-08-28 07:06:34',
                'updated_at' => '2018-08-28 07:06:34',
            ),
            29 => 
            array (
                'id' => 35,
                'parent_id' => 0,
                'order' => 0,
                'title' => '交易管理',
                'icon' => 'fa-hospital-o',
                'uri' => NULL,
                'created_at' => '2018-08-28 07:12:37',
                'updated_at' => '2018-08-28 07:12:37',
            ),
            30 => 
            array (
                'id' => 36,
                'parent_id' => 35,
                'order' => 0,
                'title' => '订单管理',
                'icon' => 'fa-cart-arrow-down',
                'uri' => 'order',
                'created_at' => '2018-08-28 07:13:02',
                'updated_at' => '2018-08-28 07:14:04',
            ),
            31 => 
            array (
                'id' => 37,
                'parent_id' => 35,
                'order' => 0,
                'title' => '返利订单管理',
                'icon' => 'fa-beer',
                'uri' => 'rebate-order',
                'created_at' => '2018-08-28 07:14:45',
                'updated_at' => '2018-08-28 07:14:45',
            ),
            32 => 
            array (
                'id' => 38,
                'parent_id' => 0,
                'order' => 0,
                'title' => '资金管理',
                'icon' => 'fa-credit-card-alt',
                'uri' => NULL,
                'created_at' => '2018-08-28 07:15:51',
                'updated_at' => '2018-08-28 07:15:51',
            ),
            33 => 
            array (
                'id' => 39,
                'parent_id' => 38,
                'order' => 0,
                'title' => '帐户管理',
                'icon' => 'fa-user-secret',
                'uri' => 'account',
                'created_at' => '2018-08-28 07:17:26',
                'updated_at' => '2018-08-28 07:17:26',
            ),
        ));
        
        
    }
}