<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banners')->delete();
        
        \DB::table('banners')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'swiper',
                'title' => '网易',
                'img_path' => 'images/1685542f31863390a17c43aaa1ae4deb.jpg',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => 'http://www.163.com',
                'nav' => 'WebScreen',
                'params' => '{}',
                'status' => '1',
                'created_at' => 1528164608,
                'updated_at' => 1534134429,
                'created_by' => 1,
                'updated_by' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'swiper',
                'title' => '腾讯',
                'img_path' => 'images/2303067452734c966413d1df27e95a40.jpg',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => 'http://www.qq.com',
                'nav' => 'WebScreen',
                'params' => '{}',
                'status' => '1',
                'created_at' => 1528165709,
                'updated_at' => 1534134450,
                'created_by' => 1,
                'updated_by' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'swiper',
                'title' => '淘宝',
                'img_path' => '1/6WxQilPPOsFMsaLRpZutWYppegDrnbHS.jpg',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => 'http://www.taobao.com',
                'nav' => 'WebScreen',
                'params' => '{}',
                'status' => '1',
                'created_at' => 1528165781,
                'updated_at' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'type' => 'swiper',
                'title' => '百度',
                'img_path' => '1/RKG5TlhVRGNNg_lZCzJ2c4vR8agQr6g8.jpg',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => 'http://www.baidu.com',
                'nav' => 'WebScreen',
                'params' => '{}',
                'status' => '0',
                'created_at' => 1528165885,
                'updated_at' => 1528168262,
                'created_by' => 1,
                'updated_by' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'type' => 'recommend',
                'title' => '女装',
                'img_path' => '1/0q6siDJMkz9J1BPD6U0_LygUzhxKkIn4.png',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => NULL,
                'nav' => 'ChannelScreen',
                'params' => '{"channelId": 18188914}',
                'status' => '1',
                'created_at' => 1528256180,
                'updated_at' => 1534147170,
                'created_by' => 1,
                'updated_by' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'type' => 'recommend',
                'title' => '美妆',
                'img_path' => '1/iAwsWr9ywmBFo_hKLl5RarvgTj97vJdy.png',
                'img_base_url' => 'http://zg-storage.zhicaikeji.com/source',
                'url' => NULL,
                'nav' => 'ChannelScreen',
                'params' => '{"channelId": 18188917}',
                'status' => '1',
                'created_at' => 1528256263,
                'updated_at' => 1534147197,
                'created_by' => 1,
                'updated_by' => 1,
            ),
        ));
        
        
    }
}