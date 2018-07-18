<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', function () {
    return 'hello world';
});
//Route::resource('banner', 'BannerController', ['only' => [
////    'index', 'show'
////]]);
//Route::resource('/banner','BannerController',['only'=>['index','show']]);
Route::get('/banner/index', 'Api\BannerController@index');
Route::get('/banner/show/{banner}', 'Api\BannerController@show');
Route::get('category','Api\GoodsCategoryController@index');
Route::middleware('auth:api')->get('/userInfo', function (Request $request) {
    $user = $request->user();
    return [
        createInvitationCode($user->id),
        decodeInvitationCode('000000A'),
        $user,
    ];
});

Route::post('passport/login','Api\Auth\LoginController@login');
Route::post('passport/fast-login','Api\Auth\FastLoginController@login');
Route::post('passport/password-reset','Api\Auth\ResetPasswordController@reset');
Route::post('passport/register','Api\Auth\RegisterController@register');
Route::post('send-code','Api\Auth\RegisterController@sendCheckCode');
//Route::post('send-code','Toplan\Sms\SmsController@postSendCode');

Route::middleware('auth:api')->group(function (){
    Route::get('user/info','Api\UserController@info');
    Route::post('user/update','Api\UserController@update');
    Route::post('user/avatar','Api\UserController@avatar');
});

