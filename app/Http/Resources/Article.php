<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function PHPSTORM_META\map;

class Article extends JsonResource
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
        $parent['thumbnail'] = \Storage::url($this->thumbnail);
        if(is_array($this->images)) {
            $parent['images'] = array_map(function ($image) {
                return \Storage::url($image);
            }, $this->images);
        }else{
            $parent['images'] = [];
        }
        return $parent;
    }
}
