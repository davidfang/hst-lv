<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Circle extends JsonResource
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
        $parent['author'] = $this->createdBy->name;
        $parent['avatar'] = $this->createdBy->avatar;
        $parent['thumbnail'] = \Storage::url($this->thumbnail);
        if(is_array($this->images)) {
            $parent['images'] = array_map(function ($image) {
                return \Storage::url($image);
            }, $this->images);
        }else{
            $parent['images'] = [];
        }
        $parent['created_at'] = $this->created_at->diffForHumans();
        return $parent;
    }
}
