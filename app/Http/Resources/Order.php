<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        $taobaoPid = explode('_',$user->taobao_pid);
        $parent = parent::toArray($request);
        $parent['self_pid'] = $taobaoPid[3];
        return $parent;
    }
}
