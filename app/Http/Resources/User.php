<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = parent::toArray($request);
        $grade = [
          '0'=>'VIP会员',
            '1'=>'超级会员',
            '2'=>'运营商'
        ];
        $result['grade']=$grade[$this->grade];
        return $result;
    }
}
