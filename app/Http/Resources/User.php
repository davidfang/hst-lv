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
//        $avatar = empty($this->avatar)?'/avatar/avatar-logo.png':$this->avatar;
//        $result['avatar'] = \Storage::url($avatar);
        if(substr($this->avatar ,0,4) != 'http') {
            $avatar = empty($this->avatar) ? '' : \Storage::disk(env('DISK'))->url($this->avatar);
        }else{
            $avatar = $this->avatar;
        }
        $result['avatar'] = $avatar;
        return $result;
    }
}
