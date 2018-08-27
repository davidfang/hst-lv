<?php

namespace App\Console\Commands;

use App\Helpers\AccountOperating;
use Illuminate\Console\Command;

class TaobaoRebateOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:rebateOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '淘宝返利订单';

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
        $rebateOrderInfo[0] = [
            'trade_parent_id'=>123,//淘宝父订单号
            'trade_id'=>123,	//淘宝订单号
            'num_iid'=>123,//商品ID
            'item_title'=>'女装',//商品标题
            'item_num'=>123,//商品数量
            'price'=>'88.00',//单价
            'pay_price'=>'85.00',//实际支付金额
            'seller_nick'=>'我是卖家',//卖家昵称
            'seller_shop_title'=>'XX旗舰店',	//卖家店铺名称
            'commission'=>'5.00',//推广者获得的佣金金额
            'commission_rate'=>'20.00',//推广者获得的佣金比例
            'unid'=>'20',//推广者unid
            'create_time'=>'2018-08-05 10:37:48',	//淘客订单创建时间
            'earning_time'=>'2018-08-05 10:37:48',//淘客订单结算时间

        ];
        $rebateOrderInfo[1] = [
            'trade_parent_id'=>1234,//淘宝父订单号
            'trade_id'=>1234,	//淘宝订单号
            'num_iid'=>1234,//商品ID
            'item_title'=>'男装',//商品标题
            'item_num'=>1234,//商品数量
            'price'=>'98.00',//单价
            'pay_price'=>'95.00',//实际支付金额
            'seller_nick'=>'我是卖家',//卖家昵称
            'seller_shop_title'=>'YY旗舰店',	//卖家店铺名称
            'commission'=>'6.00',//推广者获得的佣金金额
            'commission_rate'=>'20.00',//推广者获得的佣金比例
            'unid'=>'20',//推广者unid
            'create_time'=>'2018-07-05 10:37:48',	//淘客订单创建时间
            'earning_time'=>'2018-07-05 10:37:48',//淘客订单结算时间

        ];
        $rebateOrderInfo[2] = [
            'trade_parent_id'=>1235,//淘宝父订单号
            'trade_id'=>1235,	//淘宝订单号
            'num_iid'=>1235,//商品ID
            'item_title'=>'男装',//商品标题
            'item_num'=>1235,//商品数量
            'price'=>'98.00',//单价
            'pay_price'=>'95.00',//实际支付金额
            'seller_nick'=>'我是卖家',//卖家昵称
            'seller_shop_title'=>'YY旗舰店',	//卖家店铺名称
            'commission'=>'8.00',//推广者获得的佣金金额
            'commission_rate'=>'20.00',//推广者获得的佣金比例
            'unid'=>'20',//推广者unid
            'create_time'=>'2018-07-15 10:37:48',	//淘客订单创建时间
            'earning_time'=>'2018-07-15 10:37:48',//淘客订单结算时间

        ];
        AccountOperating::rebateOder($rebateOrderInfo[1]);
    }
}
