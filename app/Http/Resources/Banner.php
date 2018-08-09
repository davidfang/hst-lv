<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
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
        $parent['img'] = \Storage::url($this->img_path);
        $parent['params'] = json_decode($this->params);
        unset($parent['img_path'],$parent['img_base_url']);
        return $parent;
    }
}
