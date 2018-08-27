<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
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
        unset($parent['created_by'],$parent['updated_by'],$parent['created_at'],$parent['updated_at'],$parent['deleted_at']);
        return $parent;
    }
}
