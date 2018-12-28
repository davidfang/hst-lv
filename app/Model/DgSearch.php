<?php

namespace App\Model;

use App\Common\TaoBao;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DgSearch extends Model
{
    use SoftDeletes;

    protected $table = 'dg_search';
    protected $primaryKey = 'num_iid';
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['num_iid'];
    /**
     * 设置小图
     * @param $small_images
     */
    public function setSmallImagesAttribute($small_images)
    {
        if (is_array($small_images)) {
            $this->attributes['small_images'] = json_encode($small_images);
        }
    }

    /**
     * 获取小图
     * @param $small_images
     * @return mixed|string
     */
    public function getSmallImagesAttribute($small_images)
    {
        if(!empty($small_images)){
            $small_images                           =   json_decode($small_images, true);
            foreach ($small_images as $k=>$v){
                $small_images[$k]                   =   get_image_url($v);
            }
        }
        return $small_images ? $small_images : '';
    }

    /**
     * 获取淘口令
     * @param $value
     * @return string
     */
//    public function getTpwdAttribute($value){
//        if (!empty($value) && Carbon::now()->lt((new Carbon($this->tpwd_created_at))->addDay(30))) {
//            return $value;
//        }
//
//        $url                                =   $this->click_url;
//        if($this->isCoupon()){
//            $url                            =   $this->coupon_share_url;
//        }
//        if(empty($url)){
//            $url                            =   $this->item_url;
//        }
//        $taobao = new TaoBao();
//        $model = $taobao->tpwd($this->title,$url,$this->pict_url,'{}');
//        if($model != '') {
//
//            $this->attributes['tpwd'] = $model;
//            $this->attributes['tpwd_created_at'] = Carbon::now();
//            if ($this->id > 0) {
//                $this->save();
//            }
//        }
//
//        return $model;
//    }
    /**
     * 检查是不是优惠券商品
     * @return bool
     */
    public function isCoupon(){
        if(!empty($this->coupon_end_time)) {
            if (Carbon::now()->gt(new Carbon($this->coupon_end_time))) {
                $this->coupon_status        =   0;
            }
        }else{
            $this->coupon_status = 0;
        }
        return $this->coupon_status > 0 ? true : false;
    }
}
