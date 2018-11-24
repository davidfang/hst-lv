<?php

namespace App\Http\Controllers\Api;

use App\Model\Notices;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class NoticesController extends Controller
{
    public function index(Request $request){
        $notices = Notices::where('status','1')->get(['id','title','url','body']);
        if($notices) {
            return $this->success($notices);
        }else{
            return $this->message('没有消息');
        }
    }
}
