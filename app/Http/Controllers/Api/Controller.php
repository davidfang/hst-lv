<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helpers\ApiResponse;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Laravel\Passport\Client;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

    /**
     * The user has been authenticated.
     * 调用认证接口获取授权码
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticateClient(Request $request,$user)
    {
        $credentials = $request->only('mobile', 'password');;

        // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => isset($credentials['mobile'])?$credentials['mobile']:$user->mobile,
            'password' => isset($credentials['password'])? $credentials['password'] : $user->password,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = \Route::dispatch($proxy);
        //echo '<pre>';
        //var_dump($response);
        //修改用户登录时间和ip
        $user->last_login_time = Carbon::now()->toDateTimeString();
        $user->last_login_ip = $request->ip();
        $user->save();
        $content = $response->content();
        $content = json_decode($content,true);
        $content['password'] = $user->password != '1';
        return $content;
    }
    /**
     * The user has been authenticated.
     * 调用认证接口获取授权码
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticateClientCredentials(Request $request)
    {
        $credentials = $request->only('mobile');;

        // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => $credentials['mobile'],
            'password' => $credentials['password'],
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = \Route::dispatch($proxy);
        //echo '<pre>';
        //var_dump($response);

        return $response->content();
    }
}
