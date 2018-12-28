<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaobaoPid extends Model
{
    use SoftDeletes;

    protected $table = 'taobaoPid';

    /**
     * 用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(User::class,'id','userId');
    }
}
