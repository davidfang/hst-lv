<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Helpers\ApiResponse;
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
    protected function authenticateClient(Request $request)
    {
        $credentials = $request->only('email', 'password');;

        // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        return $response->content();
    }
}
