<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
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
        $userId = $this->user_id;
        $fans = User::where('parent_id',$userId)->orWhere('grandpa_id',$userId)->first([\DB::raw('count(*) as fans')]);
        $parent['fans'] =  $fans->fans;
        return $parent;
    }
}
