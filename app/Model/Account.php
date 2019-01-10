<?php

namespace App\Model;

use App\User;
use Encore\Admin\Auth\Database\Administrator;
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
    /**
     * 创建者
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function createdBy(){
        return $this->hasOne(Administrator::class,'id','created_by');
    }

    /**
     * 修改者
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function updatedBy(){
        return $this->hasOne(Administrator::class,'id','updated_by');
    }

    /**
     * 用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
