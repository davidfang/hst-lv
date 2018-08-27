<?php

namespace App\Console\Commands;

use App\Helpers\AccountOperating;
use Illuminate\Console\Command;

class TaobaoOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taobao:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '收到淘宝订单';

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
        $orderInfo[0] = [
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
            
            'tk_status' => '13',//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功

            'tk3rd_type'=>'爱淘宝',//第三方服务来源，没有第三方服务，取值为“--”
            'tk3rd_pub_id'=>'123',//第三方推广者ID
            'order_type'=>'天猫',//订单类型，如天猫，淘宝
            'income_rate'=>'0.008',//收入比率，卖家设置佣金比率+平台补贴比率
            'pub_share_pre_fee'=>'0.03',//效果预估，付款金额*(佣金比率+补贴比率)*分成比率
            'subsidy_rate'=>'0.003',//补贴比率
            'subsidy_type'=>'1',//补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4
            'terminal_type'=>'2',//成交平台，PC:1，无线:2
            'auction_category'=>'办公设备/耗材',//类目名称
            'site_id'=>'123',//来源媒体ID
            'site_name'=>'返利推广',//来源媒体名称
            'adzone_id'=>'123',//广告位ID
            'adzone_name'=>'右下广告位',//广告位名称
            'alipay_total_price'=>'3.6',//付款金额
            'total_commission_rate'=>'0.005',//佣金比率
            'total_commission_fee'=>'0.02',//佣金金额
            'subsidy_fee'=>'0.01',//补贴金额
            'relation_id'=>'3223',//渠道关系ID
        ];
        $orderInfo[1] = [
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

            'tk_status' => '12',//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功

            'tk3rd_type'=>'爱淘宝',//第三方服务来源，没有第三方服务，取值为“--”
            'tk3rd_pub_id'=>'123',//第三方推广者ID
            'order_type'=>'天猫',//订单类型，如天猫，淘宝
            'income_rate'=>'0.008',//收入比率，卖家设置佣金比率+平台补贴比率
            'pub_share_pre_fee'=>'0.03',//效果预估，付款金额*(佣金比率+补贴比率)*分成比率
            'subsidy_rate'=>'0.003',//补贴比率
            'subsidy_type'=>'1',//补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4
            'terminal_type'=>'2',//成交平台，PC:1，无线:2
            'auction_category'=>'办公设备/耗材',//类目名称
            'site_id'=>'123',//来源媒体ID
            'site_name'=>'返利推广',//来源媒体名称
            'adzone_id'=>'123',//广告位ID
            'adzone_name'=>'右下广告位',//广告位名称
            'alipay_total_price'=>'3.6',//付款金额
            'total_commission_rate'=>'0.005',//佣金比率
            'total_commission_fee'=>'0.02',//佣金金额
            'subsidy_fee'=>'0.01',//补贴金额
            'relation_id'=>'3223',//渠道关系ID
        ];
        $orderInfo[2] = [
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

            'tk_status' => '13',//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功

            'tk3rd_type'=>'爱淘宝',//第三方服务来源，没有第三方服务，取值为“--”
            'tk3rd_pub_id'=>'123',//第三方推广者ID
            'order_type'=>'天猫',//订单类型，如天猫，淘宝
            'income_rate'=>'0.008',//收入比率，卖家设置佣金比率+平台补贴比率
            'pub_share_pre_fee'=>'0.03',//效果预估，付款金额*(佣金比率+补贴比率)*分成比率
            'subsidy_rate'=>'0.003',//补贴比率
            'subsidy_type'=>'1',//补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4
            'terminal_type'=>'2',//成交平台，PC:1，无线:2
            'auction_category'=>'办公设备/耗材',//类目名称
            'site_id'=>'123',//来源媒体ID
            'site_name'=>'返利推广',//来源媒体名称
            'adzone_id'=>'123',//广告位ID
            'adzone_name'=>'右下广告位',//广告位名称
            'alipay_total_price'=>'3.6',//付款金额
            'total_commission_rate'=>'0.005',//佣金比率
            'total_commission_fee'=>'0.02',//佣金金额
            'subsidy_fee'=>'0.01',//补贴金额
            'relation_id'=>'3223',//渠道关系ID
        ];
        AccountOperating::order($orderInfo[1]);
    }
}
