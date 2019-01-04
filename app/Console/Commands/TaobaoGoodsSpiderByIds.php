<?php

namespace App\Console\Commands;

use App\Model\CategoryByGoods;
use Illuminate\Console\Command;

class TaobaoGoodsSpiderByIds extends SpiderByGoodsId
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:goodsSpiderByIds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '淘宝根据产品ID采集商品';

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
        $categoryByGoods = CategoryByGoods::where([['date','=',date('Y-m-d')],['status','false']])->get();
        foreach ($categoryByGoods as $categoryByGood){
            $this->speedByTaobao($categoryByGood);
        }
    }
}
