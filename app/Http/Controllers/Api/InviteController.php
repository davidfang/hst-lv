<?php

namespace App\Http\Controllers\Api;

use App\Model\Invite;
use App\Http\Resources\Invite as InviteResource;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class InviteController extends Controller
{
    public function Index(Request $request){
        $invite = Invite::where('status','1')->first();
        if($invite){
            return $this->success(new InviteResource($invite));
        }else{
            return $this->failed('服务器开小差儿了');
        }
    }

    /**
     * 游客
     * @param Request $request
     * @return mixed
     */
    public function guest(Request $request){
        $invite = Invite::where('status','1')->first();
        if($invite){
            return $this->success(new InviteResource($invite));
        }else{
            return $this->failed('服务器开小差儿了');
        }
    }
}
