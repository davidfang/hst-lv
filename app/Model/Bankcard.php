<?php

namespace App\Model;

use App\User;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Bankcard extends Model
{
    use SoftDeletes;

    protected $table = 'bankcard';

    public $fillable = ['user_id','channel','bank_name','name','bank_card_no','created_at','updated_at'];
    public $hidden = ['created_at','updated_at','updated_by'];
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
