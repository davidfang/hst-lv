<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * 可以根据多项查找用户
     * @param $login
     * @return User|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public function findForPassport($username)
    {
        return $this->orWhere('email', $username)->orWhere('mobile', $username)->first();
    }

    /**
     * 可以根据用户hash过后的密文获得access_token
     * @param $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return $password == $this->password || Hash::check($password, $this->password);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mobile','name', 'nickname', 'password','parent_id','invitation_code','ip','last_login_ip','last_login_time','grandpa_id','operator_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','parent_id','updated_at'
    ];

    /**
     * 推荐人
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentUser(){
        return $this->hasOne(User::class,'id','parent_id');
    }

    /**
     * 关联的推荐人
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenUser(){
        return $this->hasMany(User::class,'parent_id','id');
    }

    /**
     * 获得粉丝信息
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function fans($id){
        return self::where([['parent_id',$id],['status','1']])->select(['id','mobile','nickname','avatar','created_at']);
    }

    /**
     * 获得孙子信息
     * @param $id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function grandson($id){
        return self::where([['grandpa_id',$id],['parent_id','<>',$id],['status','1']])->select(['id','mobile','nickname','avatar','created_at']);
    }
}
