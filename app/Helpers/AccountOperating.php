<?php
/**
 * 用户账户操作
 * User: david
 * Date: 2018/8/19
 * Time: 上午9:01
 */

namespace App\Helpers;

use App\Model\Account;
use App\Model\AccountLog;
use App\Model\OrderHistory;
use App\Model\WithdrawalApplication;
use App\Model\WithdrawalLog;
use App\Model\Order;
use App\Model\RebateOrder;
use App\Model\OrderRefund;
use App\User;
use Carbon\Carbon;
use DB;
use Encore\Admin\Facades\Admin;

class AccountOperating
{
    /**
     * 用户（淘宝）购物付款订单   返利订单
     * 1.订单返利表记录
     * 2.账户表查询原始记录，锁定
     * 3.写入账户日志表 ： 不可提现冻结+ 总金额+
     * 4.修改账户表，释放锁定
     *
     * @param $rebateOderInfo //淘宝获得的订单信息
     * @param $user_id
     */
    public static function rebateOder($rebateOderInfo)
    {

        //事务开始
        DB::transaction(function () use ($rebateOderInfo, &$account) {
            // 1.订单返利表记录 Todo 没有订单返利表先记id为0
            $rebateOder = RebateOrder::create($rebateOderInfo);
            $user_id = $rebateOder->unid;


            $rebateOderId = $rebateOder->id;//0;
            $amount = $rebateOder->commission;//10;

            // 2.账户表查询原始记录，锁定
            $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
            if ($account) {//帐户没被锁定
                /*
                                // 3.写入账户日志表  不可提现冻结+ 总金额+
                               $accountLog = AccountLog::insertLog($account,$amount,$amount,0,0,0,0,'RebateOrder',$rebateOderId,'淘宝订单付款');


                                // 4.修改账户表，释放锁定
                                $account->amount = $account->amount + $amount;//总金额=操作前总金额+变动金额
                                $account->freeze_uncash_balance = $account->freeze_uncash_balance + $amount;//不可提现冻结余额=操作前不可提现冻结余额 + 变动金额
                                $account->save();*/

            } else {//帐户被锁定

            }
        }, 5);
        if (is_null($account)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 订单
     * 1.订单表记录
     * 1.1 查询订单返利表
     * 2.账户表查询原始记录，锁定
     * 3.写入账户日志表：根据淘客订单状态
     *        3：订单结算     可提现金额+ 不可提现金额-
     *
     *        12：订单付款，  总金额+ 不可提现冻结金额+
     *
     *        13：订单失效，  总金额-
     *                      返利订单表订单状态：
     *                           12：订单付款 总金额- 不可提现冻结金额-
     *                           14：订单成功 总金额- 不可提现金额-
     *                           3： 订单结算 （从现有金额中减）总金额- 可提现金额-
     *
     *        14：订单成功（订单收货）    不可提现金额+ 不可提现冻结金额-
     *
     *
     * 3.1 订单返利表修改状态
     * 4.修改账户表，释放锁定
     *
     * @param $orderInfo //淘宝获得的订单信息
     */
    public static function order($orderInfo)
    {
        //事务开始
        DB::transaction(function () use ($orderInfo, &$account) {
            // 1.订单表记录 Todo 没有订单表先记id为0
            $order = Order::create($orderInfo);

            $orderId = $order->id;//0;
            $amount = $order->commission;//10;
            $earning_time = $order->earning_time;//'2018-7-15 8:34:01';//模拟订单的结算时间
            $tk_status = $order->tk_status;//'1';//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功

            // 1.1 查询订单返利表 //注意后面返利表中的金额和订单表中的金额是否一致
            $whereArray = [
                ['trade_parent_id', $order->trade_parent_id],
                ['trade_id', $order->trade_id],
                ['num_iid', $order->num_iid]
            ];
            $rebateOrder = RebateOrder::where($whereArray)->first();
            $user_id = $rebateOrder->unid;

            // 2.账户表查询原始记录，锁定
            $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
            if ($account) {//帐户没被锁定

                // 3.写入账户日志表
                /**
                 * * 3.写入账户日志表：根据淘客订单状态
                 *
                 *
                 *
                 *
                 *
                 *
                 *
                 *
                 */
                switch ($tk_status) {
                    case '3'://3：订单结算    可提现金额+ 不可提现金额-
                        $accountLog = AccountLog::insertLog($account, $amount, 0, $amount, -$amount, 0, 0, 'Order', $orderId, '交易结算');
                        $account->cash_balance + $amount;
                        $account->uncash_balance - $amount;
                        break;
                    case '12'://12：订单付款，  总金额+ 不可提现冻结金额+
                        $accountLog = AccountLog::insertLog($account, $amount, $amount, 0, 0, 0, $amount, 'Order', $orderId, '订单付款');
                        $account->amount = $account->amount + $amount;//总金额=操作前总金额+变动金额
                        $account->freeze_uncash_balance = $account->freeze_uncash_balance + $amount;//不可提现冻结余额=操作前不可提现冻结余额 + 变动金额
                        break;
                    case '13'://13：订单失效，  总金额-
                        //               返利订单表订单状态：
                        //              12：订单付款 总金额- 不可提现冻结金额-
                        //             14：订单成功 总金额- 不可提现金额-
                        //              3：订单结算  总金额- 可提现金额-

                        if ($rebateOrder->tk_status == '12') {//12：订单付款  总金额- 不可提现冻结金额-
                            $accountLog = AccountLog::insertLog($account, $amount, -$amount, 0, 0, 0, -$amount, 'Order', $orderId, '订单失效(已付款订单)');
                            $account->amount = $account->amount - $amount;
                            $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                        }
                        if ($rebateOrder->tk_status == '14') {//14：订单成功  总金额- 不可提现金额-
                            $accountLog = AccountLog::insertLog($account, $amount, -$amount, 0, -$amount, 0, 0, 'Order', $orderId, '订单失效(已成功订单)');
                            $account->amount = $account->amount - $amount;
                            $account->uncash_balance = $account->uncash_balance - $amount;
                        }
                        if ($rebateOrder->tk_status == '3') {//3：订单结算 从现有金额中减  总金额- 可提现金额-
                            $accountLog = AccountLog::insertLog($account, $amount, -$amount, -$amount, 0, 0, 0, 'Order', $orderId, '订单失效(已结算订单)');
                            $account->amount = $account->amount - $amount;
                            $account->cash_balance = $account->cash_balance - $amount;
                        }

                        break;
                    case '14'://14：订单成功(订单收货)     不可提现金额+ 不可提现冻结金额-
                        $accountLog = AccountLog::insertLog($account, $amount, 0, 0, $amount, 0, -$amount, 'Order', $orderId, '订单收货');
                        $account->uncash_balance = $account->uncash_balance + $amount;
                        $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                        break;
                }
                //3.1 订单返利表修改状态
                $rebateOrder->tk_status = $tk_status;
                $rebateOrder->save();


                // 4.修改账户表，释放锁定

                $account->save();

            } else {//帐户被锁定

            }
        }, 5);
        if (is_null($account)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 从excel表格订到的订单数据到数据表中
     *
     *
     *
     *
     *
     * @param $orderInfo //淘宝获得的订单信息
     */
    public static function orderToDb($orderInfo)
    {
        //事务开始
        DB::transaction(function () use ($orderInfo, &$account) {
             OrderHistory::firstOrCreate(array_filter($orderInfo,'is_null'));//创建订单历史记录

            // 1.1 查询订单返利表 //注意后面返利表中的金额和订单表中的金额是否一致
            $whereArray = [
                //['trade_parent_id', $orderInfo['trade_parent_id']],
                //['trade_id', $orderInfo['trade_id']],
                ['create_time',$orderInfo['create_time']],
                ['unid', $orderInfo['unid']],
                ['num_iid', $orderInfo['num_iid']]
            ];
            $user_id = $orderInfo['unid'];
            // 2.账户表查询原始记录，锁定
            $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
            if ($account) {//帐户没被锁定
                $order = Order::where($whereArray)->orderByDesc('create_time')->first();
                if ($order) {//订单已经存在
                    $orderId = $order->id;//0;
                    $amount = $order->pub_share_pre_fee;//10;淘宝后台效果预估
                    $earning_time = $order->earning_time;//'2018-7-15 8:34:01';//模拟订单的结算时间

                    $tk_status = $orderInfo['tk_status'];//'1';//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功
                    //Todo  订单存在时 对比状态 相关操作
                    if($tk_status == $order->tk_status){//已经存在的订单，订单状态没有发生变化
                        //不操作
                    }else{//订单状态发生变化
                        switch ($tk_status) {
                            case '3'://3：订单结算    不可提现金额+ 不可提现冻结金额-
                                $accountLog = AccountLog::insertLog($account, $amount, 0, 0, $amount, 0, -$amount, 'Order', $orderId, '交易结算');
                                $account->uncash_balance = $account->uncash_balance + $amount;
                                $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                                break;
                            case '12'://12：订单付款，  总金额+ 不可提现冻结金额+  这种状态应该不存在
                                $accountLog = AccountLog::insertLog($account, $amount, $amount, 0, 0, 0, $amount, 'Order', $orderId, '订单付款');
                                $account->amount = $account->amount + $amount;//总金额=操作前总金额+变动金额
                                $account->freeze_uncash_balance = $account->freeze_uncash_balance + $amount;//不可提现冻结余额=操作前不可提现冻结余额 + 变动金额
                                break;
                            case '13'://13：订单失效，  总金额-
                                //               返利订单表订单状态：
                                //              12：订单付款 总金额- 不可提现冻结金额-
                                //             14：订单成功 总金额- 不可提现金额-
                                //              3：订单结算  总金额- 可提现金额-

                                if ($order->tk_status == '12') {//12：订单付款  总金额- 不可提现冻结金额-
                                    $accountLog = AccountLog::insertLog($account, $amount, -$amount, 0, 0, 0, -$amount, 'Order', $orderId, '订单失效(已付款订单)');
                                    $account->amount = $account->amount - $amount;
                                    $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                                }
                                if ($order->tk_status == '14') {//14：订单成功  总金额- 不可提现金额-
                                    $accountLog = AccountLog::insertLog($account, $amount, -$amount, 0, -$amount, 0, 0, 'Order', $orderId, '订单失效(已成功订单)');
                                    $account->amount = $account->amount - $amount;
                                    $account->uncash_balance = $account->uncash_balance - $amount;
                                }
                                if ($order->tk_status == '3') {//3：订单结算 从现有金额中减  总金额- 可提现金额-
                                    $accountLog = AccountLog::insertLog($account, $amount, -$amount, -$amount, 0, 0, 0, 'Order', $orderId, '订单失效(已结算订单)');
                                    $account->amount = $account->amount - $amount;
                                    $account->cash_balance = $account->cash_balance - $amount;
                                }

                                break;
                            case '14'://14：订单成功(订单收货)     不可提现金额+ 不可提现冻结金额-
                                $accountLog = AccountLog::insertLog($account, $amount, 0, 0, $amount, 0, -$amount, 'Order', $orderId, '订单收货');
                                $account->uncash_balance = $account->uncash_balance + $amount;
                                $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                                break;
                        }
                        $order->tk_status = $tk_status;
                        $order->save();//更改状态
                    }

                } else {//订单不存在  新订单
                    //首先创建订单
                    $order = Order::create($orderInfo);
                    $orderId = $order->id;//0;
                    $amount = $order->pub_share_pre_fee;//10;淘宝后台 效果预估
                    $earning_time = $order->earning_time;//'2018-7-15 8:34:01';//模拟订单的结算时间

                    $tk_status = $order->tk_status;//'1';//淘客订单状态，3：订单结算，12：订单付款， 13：订单失效，14：订单成功

                    switch ($tk_status) {
                        case '3'://3：订单结算    //新订单，订单已结算  不操作
                            break;
                        case '12'://12：订单付款，  总金额+ 不可提现冻结金额+
                            $accountLog = AccountLog::insertLog($account, $amount, $amount, 0, 0, 0, $amount, 'Order', $orderId, '订单付款');
                            $account->amount = $account->amount + $amount;//总金额=操作前总金额+变动金额
                            $account->freeze_uncash_balance = $account->freeze_uncash_balance + $amount;//不可提现冻结余额=操作前不可提现冻结余额 + 变动金额
                            break;
                        case '13'://13：订单失效， 新订单上来就是失效 不操作

                            break;
                        case '14'://14：订单成功(订单收货)     不可提现金额+ 不可提现冻结金额-
                            $accountLog = AccountLog::insertLog($account, $amount, 0, 0, $amount, 0, -$amount, 'Order', $orderId, '订单收货');
                            $account->uncash_balance = $account->uncash_balance + $amount;
                            $account->freeze_uncash_balance = $account->freeze_uncash_balance - $amount;
                            break;
                    }
                }

                // 4.修改账户表，释放锁定

                $account->save();
            } else {//帐户被锁定

            }


        }, 5);
        if (is_null($account)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 订单归帐 25号操作
     * 1. 统计用户上个月25号之前的所有单子 统计返利表中返利总金额
     * 2.账户表查询原始记录，锁定
     * 3.订单归帐表写入记录 用户id，返利额，订单总数，类别
     * 4.写入账户日志表：
     *              可提现冻结金额减去返利总金额  可提现金额加上返利总金额
     * 5.修改账户表，释放锁定
     *
     *
     * @param $user_id
     * @return bool
     * @throws \Throwable
     */
    public static function orderRefund()
    {
        //1. 统计用户上个月25号之前的所有单子 统计返利表中返利金额
        $orders = Order::where('tk_status', '=', 3)
            ->whereDay('earning_time', '<', 25)
            ->whereMonth('earning_time', '=', Carbon::parse('last month')->month)
            ->groupBy('unid')
            //->select(['unid',"sum(commission) as commissionSum","count(id) as orderCount"])
            //->select()
            ->get(['unid', \DB::raw('SUM(pub_share_pre_fee) as pub_share_pre_fee_sum'), \DB::raw("count(id) as orderCount")]);
        //var_dump($orders->toArray());exit;
        foreach ($orders as $order) {
            $amount = $order->pub_share_pre_fee_sum;
            $user_id = $order->unid;
            //事务开始
            DB::transaction(function () use ($order, $user_id, $amount, &$account) {

                if ($order) {
                    // 2.账户表查询原始记录，锁定
                    $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
                    if ($account) {
                        //3.订单归帐表写入记录 用户id，返利额，订单总数，类别
                        $orderRefund = new OrderRefund();
                        $orderRefund->user_id = $user_id;
                        $orderRefund->commission = $amount;
                        $orderRefund->order = $order->orderCount;
                        $orderRefund->type = '自己消费';
                        $orderRefund->save();

                        // 4.写入账户日志表：
                        //             不可提现金额减去返利总金额  可提现金额加上返利总金额
                        $accountLog = AccountLog::insertLog($account, $amount, 0, $amount, -$amount, 0, 0, 'OrderRefund', $orderRefund->id, '订单归帐可提现');


                        //5.修改账户表，释放锁定
                        $account->cash_balance = $account->cash_balance + $amount;//可提现余额= 操作前可提现余额 + 发生金额
                        $account->uncash_balance = $account->uncash_balance - $amount;//不可提现余额= 操作前不可提现余额 - 发生金额
                        $account->save();
                    }
                }
            }, 5);
        }

    }

    /**
     * 提现申请
     * 1.账户表查询原始记录，锁定
     * 2.记录提现申请表
     * 3.写入账户日志表 ： 可提现冻结金额+ 可提现金额-
     * 4.修改账户表，释放锁定
     *
     * @param $user_id 用户ID
     * @param $amount 本次提现金额
     * @param $remark_submit 提现申请备注
     * @param $out_trade_no 支付渠道
     * @param $bankcard_id 提现银行卡ID 支付宝
     * @return bool
     * @throws \Throwable
     */
    public static function withdrawalApplication($user_id, $amount, $remark_submit, $out_trade_no, $bankcard_id)
    {
        $result = ['status'=>true,'msg'=>''];
        //事务开始
        DB::transaction(function () use ($user_id, $amount, $remark_submit, $out_trade_no, $bankcard_id, &$account,&$result) {
            // 1.账户表查询原始记录，锁定
            $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
            if ($account) {//帐户没被锁定
                if ($account->cash_balance >= $amount) {//可提现金额大于提现金额的时候才提现
                    //2.记录提现申请表
                    $withdrawalApplication = new WithdrawalApplication();
                    $withdrawalApplication->user_id = $user_id;//用户ID
                    $withdrawalApplication->amount = $amount;//本次提现金额
                    $withdrawalApplication->remark_submit = $remark_submit;//提现申请备注
                    $withdrawalApplication->out_trade_no = $out_trade_no;//支付渠道
                    $withdrawalApplication->bankcard_id = $bankcard_id;//提现银行卡ID 支付宝
                    $withdrawalApplication->status = '0';//状态：-1-驳回、0-待审核、1-审核通过待打款、2-已打款
                    $withdrawalApplication->save();

                    // 3.写入账户日志表  可提现冻结金额+ 可提现金额-
                    $accountLog = AccountLog::insertLog($account, $amount, 0, -$amount, 0, $amount, 0, 'WithdrawalApplication', $withdrawalApplication->id, '提现申请');


                    // 4.修改账户表，释放锁定
                    $account->cash_balance = $account->cash_balance - $amount;//操作后可提现余额= 操作前可提现余额 - 发生金额
                    $account->freeze_cash_balance = $account->freeze_cash_balance + $amount;//操作后可提现冻结余额= 操作前可提现冻结余额 + 发生金额
                    $account->save();
                    $result['msg'] = '提现成功';
                }else{
                    $result['status'] = false;
                    $result['msg'] = '提现金额超过可提现金额';
                }
            } else {//帐户被锁定
             $result['status'] = false;
             $result['msg'] = '稍后操作';
            }
        }, 5);
        return $result;
    }

    /**
     * 提现操作
     * 1.提现申请表查询提现记录，锁定
     * 2.账户表查询原始记录，锁定
     * 3.写入提现日志表
     * 4.写入账户日志表 ： 总金额- 可提现冻结金额-
     * 5.修改提现申请表，释放锁定
     * 6.修改账户表，释放锁定
     *
     * @param $withdrawalApplication_id 提现申请表ID
     * @param $remark_audit 提现审核备注(第三方的流水ID)
     * @return bool
     * @throws \Throwable
     */
    public static function withdraw($withdrawalApplication_id, $remark_audit)
    {
        //事务开始
        DB::transaction(function () use ($withdrawalApplication_id, $remark_audit, &$account) {
            //1.提现申请表查询提现记录，锁定
            $withdrawalApplication = WithdrawalApplication::find($withdrawalApplication_id)->lockForUpdate()->first();
            if ($withdrawalApplication && $withdrawalApplication->status == '1') {
                $user_id = $withdrawalApplication->user_id;
                $amount = $withdrawalApplication->amount;
                //2.账户表查询原始记录，锁定
                $account = Account::where('user_id', $user_id)->lockForUpdate()->first();
                if ($account) {//帐户没被锁定
                    //3.写入提现日志表
                    $withdrawalLog = new WithdrawalLog();
                    $withdrawalLog->withdrawal_application_id = $withdrawalApplication_id;//提现申请ID
                    $withdrawalLog->user_id = $user_id;
                    $withdrawalLog->admin_id = Admin::user() ? Admin::user()->id : 0;
                    $withdrawalLog->amount = $amount;
                    $withdrawalLog->save();
                    //4.写入账户日志表 ： 总金额- 可提现冻结金额-
                    $accountLog = AccountLog::insertLog($account, $amount, -$amount, 0, 0, -$amount, 0, 'WithdrawalLog', $withdrawalLog->id, '提现付款');


                    //5.修改提现申请表，释放锁定
                    $withdrawalApplication->status = '2';//状态：-1-驳回、0-待审核、1-审核通过待打款、2-已打款
                    $withdrawalApplication->updated_by = Admin::user() ? Admin::user()->id : 0;
                    $withdrawalApplication->remark_audit = $withdrawalApplication->remark_audit . '  ' . $remark_audit;//提现审核备注
                    $withdrawalApplication->save();

                    //6.修改账户表，释放锁定
                    $account->amount = $account->amount - $amount;//操作后总金额=操作前总金额 - 发生金额
                    $account->freeze_cash_balance = $account->freeze_cash_balance - $amount;//操作后可提现冻结余额= 操作前可提现冻结余额 - 发生金额
                    $account->save();

                }
            }
        }, 5);
        if (is_null($account)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 用户注册
     * 1.查出用户信息
     * 2.用户有父
     *      2.1查出父的账户
     *      2.2记入帐户日志 总金额+1元 不可提现+1元
     *      2.3给父的账户 总金额+1元 不可提现+1元
     * 3.用户有爷
     *      3.1查出爷的账户
     *      3.2记入账户日志  不可提现-1元 可提现+1元
     *      3.3给爷的账户 不可提现-1元 可提现+1元
     *
     * @param $userId
     * @throws \Throwable
     */
    public static function registerSon($userId)
    {
        $user = User::find($userId);//1.查出用户信息
        $amount = 1;//变动金额为1元
        if ($user->parent_id != null) {//有父ID
            $parent_id = $user->parent_id;
            //事务开始
            DB::transaction(function () use ($userId, $parent_id, $amount, &$parent) {
                $parentCheckAccountLog = AccountLog::where([['change_type','User'],['ref_sn',$userId],['remark','推荐直接粉丝']])->first();
                if(!$parentCheckAccountLog) {//检查此用户没有对账户生效过操作
                    //2.账户表查询原始记录，锁定 2.1查出父的账户
                    $parent = Account::where('user_id', $parent_id)->lockForUpdate()->first();
                    if ($parent) {//帐户没被锁定
                        //2.2记入帐户日志 总金额+1元 不可提现+1元
                        $accountLog = AccountLog::insertLog($parent, $amount, $amount, 0, $amount, 0, 0, 'User', $userId, '推荐直接粉丝');
                        //2.3给父的账户 总金额+1元 不可提现+1元
                        $parent->amount = $parent->amount + $amount;
                        $parent->uncash_balance = $parent->uncash_balance + $amount;
                        $parent->save();
                    }
                }

            }, 5);
        }
        if ($user->grandpa_id != null) {//有祖父ID
            $parent_id = $user->parent_id;
            $grandpa_id = $user->grandpa_id;
            //事务开始
            DB::transaction(function () use ($userId, $parent_id, $grandpa_id, $amount, &$grandpa) {
                $brother = User::where([['parent_id', $parent_id]])->first();
                if ($brother->id == $userId) {//说明是第一个用户 第一个用户将他的1元钱变为可提现
                    $grandpaCheckAccountLog = AccountLog::where([['change_type','User'],['ref_sn',$userId],['remark','推荐粉丝确认奖励']])->first();
                    if(!$grandpaCheckAccountLog) {//检查此用户没有对账户生效过操作
                        //3.账户表查询原始记录，锁定 3.1查出爷的账户
                        $grandpa = Account::where('user_id', $grandpa_id)->lockForUpdate()->first();
                        if ($grandpa) {//帐户没被锁定
                            //3.2记入账户日志 不可提现-1元 可提现+1元
                            $accountLog = AccountLog::insertLog($grandpa, $amount, 0, $amount, -$amount, 0, 0, 'User', $userId, '推荐粉丝确认奖励');
                            //3.3给爷的账户 不可提现-1元 可提现+1元
                            $grandpa->uncash_balance = $grandpa->uncash_balance - $amount;
                            $grandpa->cash_balance = $grandpa->cash_balance + $amount;
                            $grandpa->save();
                        }
                    }
                }


            }, 5);
        }
        return [
            'parent' => isset($parent) ? !is_null($parent) : false,
            'grandpa' => isset($grandpa) ? !is_null($grandpa) : false
        ];
    }

}