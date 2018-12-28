<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
class Invite extends JsonResource
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
        $parent = parent::toArray($request);
        unset($parent['created_by'],$parent['updated_by'],$parent['created_at'],$parent['updated_at']);
        if(is_array($this->images)) {
            $parent['images'] = array_map(function ($image) {
                return \Storage::disk(env('DISK'))->url($image);
            }, $this->images);
        }else{
            $parent['images'] = [];
        }
        $parent['shareContent']=str_replace('<inviteCode>',$user->invitation_code,$parent['shareContent']);
        $shareUrl = 'http://mobile.qq.com/qrcode?url='.urlencode(str_replace('<inviteCode>',$user->invitation_code,$parent['shareUrl']));
        //$parent['waterMark']='?imageView2/0/q/75%7Cwatermark/1/image/'.base64_encode($shareUrl).'/dissolve/100/gravity/NorthWest/dx/280/dy/980%7Cwatermark/2/text/'.base64_encode($user->invitation_code).'/font/6buR5L2T/fontsize/720/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/310/dy/1245%7Cimageslim';
        $parent['waterMark']='?imageView2/0/q/75%7Cwatermark/2/text/'.base64_encode($user->invitation_code).'/font/6buR5L2T/fontsize/720/fill/IzAwMDAwMA==/dissolve/100/gravity/NorthWest/dx/310/dy/1245%7Cimageslim';
        //$parent['waterMark']= '';
        return $parent;
    }
}
