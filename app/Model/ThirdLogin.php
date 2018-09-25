<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ThirdLogin extends Model
{
    protected $table = 'third_login';
    protected $fillable = ['invitation_code', 'userId', 'uid', 'platform', 'screen_name', 'iconurl', 'accessToken', 'refreshToken', 'gender', 'unionid', 'openid', 'expires_in','other'];

    /**
     * 用户信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
