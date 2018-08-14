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
Route::get('/article-category/{category_id}','Api\ArticleController@index');//文章分类
Route::get('/article/{article}','Api\ArticleController@show');//文章详情
Route::get('circle','Api\ArticleController@circle');//圈子 文章分类为5
Route::get('category','Api\GoodsCategoryController@index');//获得产品分类
//Route::get('taobao/recommend','Api\GoodsShareController@index');//推荐产品
//Route::get('taobao/{goodsShare}','Api\GoodsShareController@show');
Route::get('goods/recommend','Api\GoodsController@index');//首页产品推荐
Route::get('goods/show','Api\GoodsController@show');//显示产品
Route::post('goods/set-detail','Api\GoodsController@setDetail');//设置产品详情
Route::get('goods/category','Api\GoodsController@category');//分类产品列表
Route::get('search','Api\SearchController@index');
Route::post('feed-back','Api\FeedBackController@create');//用户反馈
Route::get('/userInfo', function (Request $request) {
    $user = \App\User::find($request->get('id'));
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

