<?php

namespace App\Console\Commands;

use App\Model\GoodsCategory;
use Illuminate\Console\Command;
use App\Common\TaoBao;
use App\Model\GoodsShare;

class TaobaoUpdateGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:updateGoods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新商品信息，将选品库中商品加入到数据库中';

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
        //临时为py输出使用
//        $categories = GoodsCategory::allSelectOptions();
//        foreach ($categories as $category){
//            $str1 = substr($category,0,strpos($category,'-')?strpos($category,'-'):-1);
//            $str2 = substr($category,strpos($category,'-')?strpos($category,'-')+1:0);
//            $this->info("['$str1','$category','$str2'],");
//        }
//        exit;
        $categories = GoodsCategory::allUpdatedGoods();
//        var_dump($categories);exit;
        unset($categories[0]);
        $this->info(date('Y-m-d H:i:s') . ' 更新商品信息，将选品库中商品加入到数据库中');
        $allTotal =0;//总共条数
        foreach ($categories as $categoryId => $category) {
            $this->info('获取分类：' . $category.' 开始');

            $pageNo = 0;//页码
            $pageTotal = 1;//总共多少页
            do {
                $pageNo = $pageNo + 1;
                $taobao = new TaoBao();
                $list = $taobao->favouriteItem($categoryId, $pageNo);
                if ($list) {
                    $total = $taobao->getTotal();
                    if($pageNo == 1) {
                        $allTotal = $allTotal + $total;
                    }
                    $pageTotal = $taobao->getPages();
                    $this->info($category.' '. $pageNo.' 页/共 '.$pageTotal.' 页');
                    //$category = null;
                    $printList = [];
                    foreach ($list as $k => $v) {
                        $printList[] = [
                            'title'=>$v->title,
                            'reserve_price'=>$v->reserve_price
                        ];

                        /*if($category){
                            $list[$k]->category_id              =   $category->id;
                        }*/
                        //  临时注释 $list[$k]->category_id = $categoryId;
                        //是否推荐商品
//                if(isset($channel) && !empty($channel)){
//                    $list[$k]->channel_id               =   $channel->id;
//                }
                        $goods = GoodsShare::getByNumIid($v->original_id);
                        if (!empty($goods)) {
                            $v->id = $goods->id;
                            $v->exists = true;
                        }
                        $v->save();
                    }
                    //var_dump($list);
                    $this->table(['title','reserve_price'],$printList);
                }
            }while($pageNo < ceil($pageTotal));

            $categoryInfo = GoodsCategory::find($categoryId);
            $categoryInfo->updated_goods = 1;
            $categoryInfo->save();
            $this->info('获取分类：' . $category.' 结束 共 '.$pageTotal.' 页 '.$total.' 条');
            $this->info('===========================================================');

        }
        $this->info('更新商品信息结束 分类:'.count($categories).' 共 '.$allTotal.' 条');
    }
}
