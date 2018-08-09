<?php

namespace App\Model;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'created_at','updated_at','created_by','updated_by'
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
     * 分类
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(){
        return $this->hasOne(ArticleCategory::class,'id','category_id');
    }
    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images, true);
    }
}
