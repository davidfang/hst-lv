<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'account';

    public static function initAcount($user_id){
        $account = new self();
        $account->user_id = $user_id;
        $account->amount = 0;
        $account->cash_balance = 0;
        $account->uncash_balance = 0;
        $account->freeze_cash_balance = 0;
        $account->freeze_uncash_balance = 0;
        $account->save();
        return $account;
    }
}
