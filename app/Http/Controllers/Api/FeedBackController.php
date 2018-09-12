<?php

namespace App\Http\Controllers\Api;

use App\Model\Feedback;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

//use App\Http\Controllers\Controller;

class FeedBackController extends Controller
{
    public function create(Request $request){
        $data = $request->only(['body','image','userId']);
        $validator = Validator::make($data, [
            'body' => 'required|min:10,max:300',
            'image'=>'required|string|max:1024,min:15'
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        //Request::getClientIp();
        //$request->ip();

        //var_dump($request->user(),\Auth::user(),\Auth::id());exit;
        $user_id = $data['userId'];
//        $dir = $user_id ? 'feedback/'.$user_id : 'feedback/other';
//        $path = $request->file('image')->store($dir);
//        $imagePath = asset('storage/'.$path);
        Feedback::create([
            'user_id'=>$user_id ? $user_id : 0,
            'body'=>$data['body'],
            'image'=>$data['image'],
            //'ip'=>$request->ip()
        ]);
        return $this->message('提交成功');
    }
}
