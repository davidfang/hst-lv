<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'num_iid';
    public $incrementing = false;
    protected $keyType = 'string';
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
        if (!empty($small_images)) {
            $small_images = json_decode($small_images, true);
            foreach ($small_images as $k => $v) {
                $small_images[$k] = get_image_url($v);
            }
        }
        return $small_images ? $small_images : [];
    }

    /**
     * 获取产品详情图片列表
     * @param $detail
     * @return mixed|null
     */
    public function getDetailAttribute($detail)
    {
        if (!empty($detail)) {
            $detail = json_decode($detail, true);
        }
        return $detail ? $detail : null;
    }
}
