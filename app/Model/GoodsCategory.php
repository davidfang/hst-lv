<?php

namespace App\Model;

use App\User;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    protected $table = 'goods_category';
    public $incrementing = false;
    //是否管理created_at 和updated_at字段，true-是，false-否
    public $timestamps =  true;
    //必须，模型日期列的存储格式（unix时间戳存储）
    protected $dateFormat = 'U';
    //
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','created_by','updated_by'
    ];

    /**
     * 上级分类
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentCategory(){
        return $this->hasOne(GoodsCategory::class,'id','parent_id');
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
}
