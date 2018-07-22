<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsShare extends JsonResource
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
        unset(
            //$result['id'],
            $result['created_at'],$result['updated_at'],$result['from_site'],
            $result['channel_id'],$result['is_recommend'],$result['view']
        );
        return $result;
    }
}
