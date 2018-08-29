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
                'remark' => '版本',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-28 07:30:02',
                'updated_at' => '2018-08-28 07:30:02',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'downloadUrl',
                'val' => 'http://hst.zhicaikeji.com/donwload',
                'remark' => '下载地址',
                'status' => '1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2018-08-28 07:32:15',
                'updated_at' => '2018-08-28 07:32:15',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}