<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Http\Resources\User as UserResources;
use App\Http\Resources\Fans as FansResources;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 更新用户头像。
     *
     * @param  Request $request
     * @return Response
     */
    public function avatar(Request $request)
    {
        $data = $request->only(['avatar']);
        $validator = Validator::make($data, [
            'avatar' => 'required|image|dimensions:max_width=1024,max_height=1024'
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        $user = $request->user();
        $path = $request->file('avatar')->store('avatars/' . $user->id);
        \Storage::disk('qiniu')->put($path);
        $avatar = \Storage::disk(env('DISK'))->url($path);
        $user->avatar = $path;
        $user->save();
        $this->message('上传成功');
        return $this->success(['avatar' => $avatar]);
    }

    /**
     * 用户信息
     * @return mixed
     */
    public function info()
    {

        return $this->success(new UserResources(Auth::user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->only(['name', 'email', 'nickname', 'age', 'gender']);
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|digits_between:2,10',
            'email' => 'sometimes|required|email',
            'nickname' => 'sometimes|required|string|between:2,10',
            'age' => 'sometimes|required|integer|between:16,100',
            'gender' => 'sometimes|required|in:1,2',
        ]/*,[
            'name.required'=>'姓名不能为空',
            'name.digits_between'=>'姓名必须2-10位',
            'email.require'=>'邮箱不能为空',
            'email.email'=>'邮箱格式不正确',
            'nickname.required'=>'昵称不能为空',
            'nickname.digits_between'=>'昵称必须2-10位',
            'age.integer'=>'年龄必须是数字',
            'age.required'=>'年龄必须填',
            'age.between'=>'请填写真实年龄'
        ]*/
        );
        if ($validator->fails()) {
            return $this->setStatusCode(401)->failed($validator->errors());
        }
        $user = Auth::user();
        foreach ($data as $k => $v) {
            $user->$k = $v;
        }
        $user->save();

        return $this->message('操作成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * 粉丝
     * @param Request $request
     */
    public function fans(Request $request)
    {
        $userId = Auth::id();
        //$child =  User::where([['parent_id','in',[$userId]],['status','1']])->paginate(15,['id','mobile','avatar','nickname','created_at']);
        $child = User::fans($userId)->paginate(20);
        return $this->success(FansResources::collection($child)->resource);
    }

    /**
     * 粉丝
     * @param Request $request
     */
    public function grandFans(Request $request)
    {
        $userId = Auth::id();
        //$child =  User::where([['parent_id','in',[$userId]],['status','1']])->paginate(15,['id','mobile','avatar','nickname','created_at']);
        $child = User::grandson($userId)->paginate(20);
        return $this->success(FansResources::collection($child)->resource);
    }
}
