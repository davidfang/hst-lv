<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;

class Qiniucontroller extends Controller
{
    /**
     *
     */
    public function index(){

    }

    /**
     * 上传头像获取token
     */
    public function getAvatarToken(Request $request){
        $user = $request->user();
        $disk = \Storage::disk(env('DISK'));
        $key = 'avatars/' . $user->id. '/'.uniqid().'jpg';
        $policy = array(
            'callbackUrl' => 'http://hst-api.zhicaikeji.com/qiniu/callBack',
            //'callbackBody' => ''
            'callbackBody' => 'uid='.$user->id.'&avatar='.$key
        );

        $token = $disk->getDriver()->uploadToken($key,600,$policy);              //获取上传Token
        //$token = $disk->getDriver()->uploadToken($key,3600);              //获取上传Token
        return $this->success(['token'=>$token,'key'=>$key]);
    }
    /**
     * 用户反馈获取token
     */
    public function getFeedbackToken(Request $request){
        //$data = $request->only(['body','image','userId']);
        $user_id = $request->post('userId');//$data['userId'];

        if(empty($user_id)){
            $key = 'feedback/other'.'/'.uniqid().'.jpg';
            $callbackBody = 'body=$(x:body)&image='.$key;
        }else{
            $key = 'feedback/'.$user_id .'/'.uniqid().'.jpg';
            $callbackBody = 'body=$(x:body)&userId='.$user_id.'&image='.$key;
        }

        $disk = \Storage::disk(env('DISK'));
        $policy = array(
            'callbackUrl' => 'http://hst-api.zhicaikeji.com/feed-back',
            //'callbackBody' => ''
            'callbackBody' => $callbackBody
        );

        $token = $disk->getDriver()->uploadToken($key,600,$policy);              //获取上传Token
        //$token = $disk->getDriver()->uploadToken($key,3600);              //获取上传Token
        return $this->success(['token'=>$token,'key'=>$key]);
    }

    /**
     * 回调
     */
    public function callBack(Request $request){
        $post = $request->post();
        $uid = $post['uid'];
        $avatar = $post['avatar'];
        $user = User::find($uid);
        if($user){
            $user->avatar = $avatar;
            $user->save();
            return $this->success(['avatar' => \Storage::disk(env('DISK'))->url($avatar)]);
        }
        return  $this->setStatusCode(401)->failed('非法上传');

    }
}
