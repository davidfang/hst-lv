<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Goods extends JsonResource
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
        preg_match_all('/满(\d*)元减(\d*)元/', $this->coupon_info, $coupon_info);
        $parent['coupon_info'] = isset($coupon_info[2]) ? $coupon_info[2][0] : 0;
        //$parent['coupon_info'] = ['满300元减10元',        300,    10];
        return $parent;
    }
}
