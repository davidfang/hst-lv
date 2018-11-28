<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $pic1 = '/image/' . str_replace(array('+','/','='),array('-','_',''),base64_encode($this->pict_url.'_600x600.jpg') ). '/dissolve/100/gravity/North/dx/0/dy/190';
        $title1 = '/text/' . str_replace(array('+','/','='),array('-','_',''),base64_encode(mb_substr($this->title,0,22))) . '/font/5b6u6L2v6ZuF6buR/fontsize/500/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/117/dy/84';
        $title2 = '/text/' . str_replace(array('+','/','='),array('-','_',''),base64_encode(mb_substr($this->title,22)) ). '/font/5b6u6L2v6ZuF6buR/fontsize/500/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/51/dy/134';
        $realPrice = '/text/' . str_replace(array('+','/','='),array('-','_',''),base64_encode($this->real_price) ). '/font/5b6u6L2v6ZuF6buR/fontsize/960/fill/I0QwMDIxQg==/dissolve/100/gravity/NorthWest/dx/96/dy/835';
        $oldPrice = '/text/' . str_replace(array('+','/','='),array('-','_',''),base64_encode($this->zk_final_price)) . '/font/5b6u6L2v6ZuF6buR/fontsize/720/fill/IzlCOUI5Qg==/dissolve/100/gravity/NorthWest/dx/96/dy/905';
        $coupon = '/text/' .str_replace(array('+','/','='),array('-','_',''), base64_encode($this->coupon_info_price)) . '/font/5b6u6L2v6ZuF6buR/fontsize/1100/fill/I0ZGRkZGRg==/dissolve/100/gravity/NorthWest/dx/510/dy/842';
        if($this->user_type ==0) {
            $parent['share_pict_url'] = env('QINIU_SHARE_PICT_TEMPLATE_URL_TB') . $pic1 . $title1 . $title2 . $realPrice . $oldPrice . $coupon;
        }else {
            $parent['share_pict_url'] = env('QINIU_SHARE_PICT_TEMPLATE_URL_TM') . $pic1 . $title1 . $title2 . $realPrice . $oldPrice . $coupon;
        }
        return $parent;
    }
}
