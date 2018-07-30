<?php

namespace App\Model;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    //是否管理created_at 和updated_at字段，true-是，false-否
    public $timestamps =  true;
    //必须，模型日期列的存储格式（unix时间戳存储）
    protected $dateFormat = 'U';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'type','title', 'img_path', 'img_base_url','url','nav','params','status'
//    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','created_by','updated_by'
    ];

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
     * 修饰一下参数返回的值，返回json数据，而不是原始字符
     * @param $params
     * @return mixed
     */
    public function getParamsAttribute($params)
    {
        if(empty($params)){
            $params = '{}';
        }
        return json_decode($params,true);
    }
}
