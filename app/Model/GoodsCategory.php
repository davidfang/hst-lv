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
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['id','title','parent_id','created_by','updated_by'];
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

    /**
     * 根据名字获得分类
     * @param $name
     * @return mixed
     */
    public static function getByName($name){
        return static::where(['title'=>$name])->first();
    }

    /**
     * 根据上级ID和名字获得分类
     * @param $parentId
     * @param $name
     * @return mixed
     */
    public static function getByParentIdAndName($parentId,$name){
        return static::where(['parent_id'=>
            $parentId,'title'=>$name])->first();
    }

    /**
     * 获得所有分类
     * @param int $parentId
     * @return array
     */
    public static function getAllCategory($parentId = 0) {
        $categories                             =   static ::getChildren($parentId);
        $allCategories                          =   array();
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $allCategories[$category->id]   =   $category;

                $categoryChild                  =   static ::getChildren($category->id);
                if (!empty($categoryChild)) {
                    $allCategories[$category->id]->child = $categoryChild;
                }
            }
        }
        return $allCategories;
    }

    /**
     * 获得所有分类ID
     * @param $parentId
     * @return array
     */
    public static function getAllCategoryId($parentId){
        $categories                             =   static ::where('parent_id' , $parentId)->orderBy('sort' ,'asc')->get();
        $allCategories[]                        =   $parentId;
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $allCategories[]                =   $category->id;

                $categoryChild                  =   static ::getAllCategory($category->id);
                if (!empty($categoryChild)) {
                    foreach ($categoryChild as $row){
                        $allCategories[]        = $row;
                    }

                }
            }
        }
        return $allCategories;
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

    /**
     * 一条分类信息
     * @param $id
     * @return mixed
     */
    public static function info($id){
        return static::where(['id'=>$id])->first();
    }

    /**
     * 一条分类信息
     * @param $id
     * @return string
     */
    public static function getName($id){
        $category                               =   static::info($id);
        if($category){
            return $category->title;
        }
        return '';
    }

    /**
     * SEO标题处理
     * @param $value
     * @return mixed
     */
    public function getSeoTitleAttribute($value){
        if(isset($this->attributes['name']) and !empty($this->attributes['name'])){
            $pinyin                              =   new Pinyin();
            $this->attributes['seo_title']       =   $pinyin->permalink($this->attributes['name']);
            return $this->attributes['seo_title'];
        }
        return $value;
    }
}
