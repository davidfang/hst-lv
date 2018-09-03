<?php

namespace App\Console\Commands;

use App\Model\GoodsCategory;
use Illuminate\Console\Command;
use App\Common\TaoBao as TaoBaoCommon;

class TaobaoFavourite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:favourite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取淘宝联盟选品库列表,建立产品分类';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $page = $this->ask('请输入页码，一般输入1');
        $taobao = new TaoBaoCommon();
        $favourite = $taobao->favourite($page);
        $this->info('总共从淘宝获得数据量：'.count($favourite));
        if ($favourite) {
            $return = [];
            foreach ($favourite as $k => $row) {
                $id = $row['favorites_id'];
                $title = $row['favorites_title'];


                $category = null;

                $categoryName = $row['favorites_title'];
                $array = explode('-', $categoryName);
                if (!isset($array[1])) {//没有横线 顶级分类
                    $category = $categoryName;
                    $parent_id = 0;
                    $parent_category = '';
                } else {
                    $parent = GoodsCategory::getByName($array[0]);
                    $parent_id = $parent ? $parent->id:0;
                    $parent_category = $array[0];
                    $category = $array[1];
                }
                $goodsCategoryArray = [
                    'id' => $id,
                    'title' => $category,

                ];
                $a = $goodsCategoryArray;
                $a['parent_id'] = $parent_id;
                $a['parent_category']=$parent_category;

                $goodsCategory = GoodsCategory::updateOrCreate($goodsCategoryArray, ['parent_id' => $parent_id,'created_by' => 1, 'updated_by' => 1]);
                $goodsCategory->save();
                $return[] = $a;
            }
            $this->table(['id','title','parent_id','parent_category'],$return);
            $this->info('更新成功');
        } else {
            $this->error('更新失败');
        }
    }
}
