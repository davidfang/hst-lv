<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountLog extends Model
{
    use SoftDeletes;
    protected $table = 'account_log';

    /**
     * 插入账户日志
     * @param $account Account 账户信息
     * @param $amountChange 变动金额
     * @param $amount 总金额变动金额
     * @param $cash_balance 可提现余额变动金额
     * @param $uncash_balance 不可提现余额变动金额
     * @param $freeze_cash_balance 冻结可提现变动金额
     * @param $freeze_uncash_balance 冻结不可提现变动金额
     * @param $change_type 变动类别
     * @param $ref_sn 关联流水ID，change_type对应不同表
     * @param $remark 交易备注
     * @return AccountLog
     */
    public static function insertLog(Account $account, $amountChange, $amount, $cash_balance, $uncash_balance, $freeze_cash_balance, $freeze_uncash_balance, $change_type, $ref_sn, $remark)
    {
        $accountLog = new self();
        $accountLog->user_id = $account->user_id;
        $accountLog->amount = $amountChange;//发生金额
        $accountLog->before_amount = $account->amount;//操作前总金额
        $accountLog->after_amount = $account->amount + $amount;//操作后总金额
        $accountLog->before_cash_balance = $account->cash_balance;//操作前可提现余额
        $accountLog->after_cash_balance = $account->cash_balance + $cash_balance;//操作后可提现余额
        $accountLog->before_uncash_balance = $account->uncash_balance;//操作前不可提现余额
        $accountLog->after_uncash_balance = $account->uncash_balance + $uncash_balance;//操作后不可提现余额
        $accountLog->before_freeze_cash_balance = $account->freeze_cash_balance;//操作前可提现冻结余额
        $accountLog->after_freeze_cash_balance = $account->freeze_cash_balance + $freeze_cash_balance;//操作后可提现冻结余额
        $accountLog->before_freeze_uncash_balance = $account->freeze_uncash_balance;//操作前不可提现冻结余额
        $accountLog->after_freeze_uncash_balance = $account->freeze_uncash_balance + $freeze_uncash_balance;//操作后不可提现冻结余额
        $accountLog->change_type = $change_type;//类型，表
        $accountLog->ref_sn = $ref_sn;//关联流水ID，change_type对应不同表
        $accountLog->remark = $remark;//交易备注
        $accountLog->save();
        return $accountLog;
    }
}
