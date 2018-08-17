<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Fans extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $avatar = empty($this->avatar)?'/gray-logo.png':$this->avatar;
        $parent['avatar'] = \Storage::url($avatar);

        return $parent;
    }
}
