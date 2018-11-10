<?php

namespace App\Imports;

use App\Model\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderImport implements ToArray, WithHeadingRow
{
    public function array(array $array)
    {
        // TODO: Implement array() method.
        return $array;
        return [


            //
            //'trade_parent_id' => $array['淘宝父订单号'],
            'trade_id' => $array['订单编号'],//淘宝订单号
            'num_iid' => $array['商品ID'],//商品ID
            'item_title' => $array['商品信息'],//商品标题
            'item_num' => $array['商品数'],//商品数量
            'price' => $array['商品单价'],//单价
            //'pay_price' => $array['实际支付金额'],//
            'seller_nick' => $array['掌柜旺旺'],//卖家昵称
            'seller_shop_title' => $array['所属店铺'],//卖家店铺名称
            'commission' => $array['预估收入'],//推广者获得的收入金额，对应联盟后台报表“预估收入”
            'commission_rate' => $array['分成比率'],//推广者获得的分成比率，对应联盟后台报表“分成比率”
            //'unid' => $array['推广者unid（已废弃）'],
            'create_time' => $array['创建时间'],//淘客订单创建时间
            'earning_time' => $array['结算时间'],//淘客订单结算时间
            'tk_status' => $array['订单状态'],//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功
            'tk3rd_type' => $array['第三方服务来源'],//第三方服务来源，没有第三方服务，取值为“--”
            //'tk3rd_pub_id' => $array['第三方推广者ID'],
            'order_type' => $array['订单类型'],//订单类型，如天猫，淘宝
            'income_rate' => $array['收入比率'],//收入比率，卖家设置佣金比率+平台补贴比率
            'pub_share_pre_fee' => $array['效果预估'],//效果预估，付款金额*(佣金比率+补贴比率)*分成比率
            'subsidy_rate' => $array['补贴比率'],//补贴比率
            'subsidy_type' => $array['补贴类型'],//补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4
            'terminal_type' => $array['成交平台'],//成交平台，PC:1，无线:2
            'auction_category' => $array['类目名称'],//类目名称
            'site_id' => $array['来源媒体ID'],//来源媒体ID
            'site_name' => $array['来源媒体名称'],//来源媒体名称
            'adzone_id' => $array['广告位ID'],//广告位ID
            'adzone_name' => $array['广告位名称'],//广告位名称
            'alipay_total_price' => $array['付款金额'],//付款金额
            'total_commission_rate' => $array['佣金比率'],//佣金比率
            'total_commission_fee' => $array['佣金金额'],//佣金金额
            'subsidy_fee' => $array['补贴金额'],//补贴金额
            'relation_id' => $array['渠道关系ID'],
        ];
        //	点击时间	结算金额	技术服务费比率
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    /*public function model(array $row)
    {
        return new Order([


            //
            //'trade_parent_id' => $row['淘宝父订单号'],
            'trade_id' => $row['订单编号'],//淘宝订单号
            'num_iid' => $row['商品ID'],//商品ID
            'item_title' => $row['商品信息'],//商品标题
            'item_num' => $row['商品数'],//商品数量
            'price' => $row['商品单价'],//单价
            //'pay_price' => $row['实际支付金额'],//
            'seller_nick' => $row['掌柜旺旺'],//卖家昵称
            'seller_shop_title' => $row['所属店铺'],//卖家店铺名称
            'commission' => $row['预估收入'],//推广者获得的收入金额，对应联盟后台报表“预估收入”
            'commission_rate' => $row['分成比率'],//推广者获得的分成比率，对应联盟后台报表“分成比率”
            //'unid' => $row['推广者unid（已废弃）'],
            'create_time' => $row['创建时间'],//淘客订单创建时间
            'earning_time' => $row['结算时间'],//淘客订单结算时间
            'tk_status' => $row['订单状态'],//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功
            'tk3rd_type' => $row['第三方服务来源'],//第三方服务来源，没有第三方服务，取值为“--”
            //'tk3rd_pub_id' => $row['第三方推广者ID'],
            'order_type' => $row['订单类型'],//订单类型，如天猫，淘宝
            'income_rate' => $row['收入比率'],//收入比率，卖家设置佣金比率+平台补贴比率
            'pub_share_pre_fee' => $row['效果预估'],//效果预估，付款金额*(佣金比率+补贴比率)*分成比率
            'subsidy_rate' => $row['补贴比率'],//补贴比率
            'subsidy_type' => $row['补贴类型'],//补贴类型，天猫:1，聚划算:2，航旅:3，阿里云:4
            'terminal_type' => $row['成交平台'],//成交平台，PC:1，无线:2
            'auction_category' => $row['类目名称'],//类目名称
            'site_id' => $row['来源媒体ID'],//来源媒体ID
            'site_name' => $row['来源媒体名称'],//来源媒体名称
            'adzone_id' => $row['广告位ID'],//广告位ID
            'adzone_name' => $row['广告位名称'],//广告位名称
            'alipay_total_price' => $row['付款金额'],//付款金额
            'total_commission_rate' => $row['佣金比率'],//佣金比率
            'total_commission_fee' => $row['佣金金额'],//佣金金额
            'subsidy_fee' => $row['补贴金额'],//补贴金额
            'relation_id' => $row['渠道关系ID'],
        ]);
        //	点击时间	结算金额	技术服务费比率
    }*/

    /**
     * 批量插入
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }
}
