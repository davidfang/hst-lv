<?php

use Illuminate\Database\Seeder;

class SystemsSettingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('systems_setting')->delete();
        
        \DB::table('systems_setting')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'version',
                'val' => '1.0',
                'remark' => '版本标记',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-28 07:30:02',
                'updated_at' => '2018-09-13 06:14:56',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'downloadUrl',
                'val' => 'http://hst-img.zhicaikeji.com/download/app-guanwang.apk',
                'remark' => '下载地址
v1.0',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-28 07:32:15',
                'updated_at' => '2018-09-13 14:33:28',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'taobaoCheck',
                'val' => 'false',
                'remark' => '淘宝审核
true时，淘宝在审核，不显示教程
false时，淘宝审核已过，显示教程',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-13 05:53:29',
                'updated_at' => '2018-09-13 23:05:32',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'shareTitle',
                'val' => '一个可以领优惠券的APP',
                'remark' => '分享标题',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-17 18:27:35',
                'updated_at' => '2018-09-17 18:27:35',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'shareText',
                'val' => '好多优惠券，还能赚钱，真的好实惠呀',
                'remark' => '分享内容',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-17 18:28:22',
                'updated_at' => '2018-09-17 18:28:22',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'shareUrl',
                'val' => 'http://quanzhenduo.zhicaikeji.com',
                'remark' => '分享地址',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-17 18:29:28',
                'updated_at' => '2018-09-17 18:29:28',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'shareImage',
                'val' => 'http://hst-img.zhicaikeji.com/icon/weixin-108x108.png',
                'remark' => '分享图片',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-17 18:30:50',
                'updated_at' => '2018-09-17 18:38:18',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'circle',
                'val' => '[{"label":"宣传材料","category":"5"},{"label":"每日爆款","category":"6"}]',
                'remark' => '圈子栏目设置：
格式为：
[
{
"label": "宣传材料",   //标签
"category": "5" //分类ID
},
{
"label": "每日爆款",
"category": "6"
}
]',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-09-20 15:10:14',
                'updated_at' => '2018-09-20 15:10:14',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}