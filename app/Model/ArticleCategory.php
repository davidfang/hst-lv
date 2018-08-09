<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Encore\Admin\Auth\Database\Administrator;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table = 'article_category';
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
     * 分类下文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(){
        return $this->hasMany(Article::class,'category_id','id');
    }
}
