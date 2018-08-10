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
    /**
     * 获得子分类
     * @param int $parentId
     * @return mixed
     */
    public static function getChildren($parentId=0){
        return static::where(['status'=>1,'parent_id'=> $parentId])->orderBy('sort' ,'asc')->get();
    }

    /**
     * 获得options参数
     * @param int $parentId
     * @return array
     */
    public static function selectOptions($parentId=0){
        $categories                             =   static::getChildren($parentId);
        $data                                   =   [0=>'无'];
        foreach ($categories as  $category){
            if(!isset($data[$category->id])){
                $data[$category->id]               =   $category->title;
            }
        }
        return array_unique($data);
    }

    /**
     * 所有select options
     * @return array
     */
    public static function allSelectOptions(){
        $categories                                     =   static::getChildren();
        $data                                           =   [0=>'无'];
        foreach ($categories as  $category){
            if(!isset($data[$category->id])){
                $data[$category->id]                    =   $category->title;
            }
            $categoryChild                          =   static::getChildren($category->id);
            foreach($categoryChild as $child){

                if(!isset($data[$child->id])){
                    //$data[$child->id]               =   "&nbsp;&nbsp;".$child->title;
                    $data[$child->id]               =   $category->title."-".$child->title;

                }
            }
        }

        return $data;
    }
}
