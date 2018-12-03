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
Route::get('/notice','Api\NoticesController@index');//获得消息
Route::get('circle','Api\ArticleController@circle');//圈子 文章分类为5
Route::get('category','Api\GoodsCategoryController@index');//获得产品分类
//Route::get('taobao/recommend','Api\GoodsShareController@index');//推荐产品
//Route::get('taobao/{goodsShare}','Api\GoodsShareController@show');
Route::get('goods/recommend','Api\GoodsController@index');//首页产品推荐
Route::get('goods/show/{goods}','Api\GoodsController@show');//显示产品
Route::post('goods/set-detail','Api\GoodsController@setDetail');//设置产品详情
Route::post('goods/set-detail2','Api\GoodsController@setDetail2');//设置产品详情 新淘宝接口地址
Route::get('goods/dtpwd/{goodsId}','Api\GoodsController@getTpwd');//默认获取产品淘口令
Route::get('goods/tpwd/{goodsId}','Api\GoodsController@getTpwd')->middleware('auth:api');//获取产品淘口令
Route::get('goods/category','Api\GoodsController@category');//分类产品列表
Route::get('product/recommend','Api\ProductController@index');//首页产品推荐
Route::get('product/show/{product}','Api\ProductController@show');//显示产品
Route::post('product/set-detail','Api\ProductController@setDetail');//设置产品详情
Route::post('product/set-detail2','Api\ProductController@setDetail2');//设置产品详情 新淘宝接口地址
Route::get('product/dtpwd/{goodsId}','Api\ProductController@getTpwd');//默认获取产品淘口令
Route::get('product/tpwd/{goodsId}','Api\ProductController@getTpwd')->middleware('auth:api');//获取产品淘口令
Route::get('product/by-tpwd','Api\ProductController@infoByTpwd');//根据淘口令获取产品

Route::get('product/buy-no/{goodsId}','Api\ProductController@buy');//未登录购买
Route::get('product/buy/{goodsId}','Api\ProductController@buy')->middleware('auth:api');//登录后购买
Route::get('product/category','Api\ProductController@category');//分类产品列表
Route::get('product/tpwd-buy','Api\ProductController@tpwdBuy');//分类产品列表
Route::get('search','Api\SearchController@index');
Route::post('feed-back','Api\FeedBackController@create');//用户反馈
Route::post('qiniu/feedbackToken','Api\Qiniucontroller@getFeedbackToken');//用户反馈获得七牛上传token
Route::post('qiniu/callBack','Api\Qiniucontroller@callBack');//七牛回调
Route::post('share','Api\ShareController@create');//记录分享结果
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
Route::post('passport/register','Api\Auth\RegisterController@register');
Route::post('send-code','Api\Auth\RegisterController@sendCheckCode');
//Route::post('send-code','Toplan\Sms\SmsController@postSendCode');
Route::post('app-set','Api\AppConfigController@index');
Route::get('app-upgrade','Api\AppConfigController@upgrade');
Route::post('thirdLogin/login','Api\Auth\ThirdLoginController@login');
Route::post('thirdLogin/bind','Api\Auth\ThirdLoginController@bind');
Route::middleware('auth:api')->group(function (){
    Route::post('passport/password-change','Api\Auth\ResetPasswordController@change');
    Route::post('passport/password-set','Api\Auth\ResetPasswordController@set');
    Route::get('user/info','Api\UserController@info');
    Route::get('user/fans','Api\UserController@fans');
    Route::get('user/grand-fans','Api\UserController@grandFans');
    Route::post('user/update','Api\UserController@update');
    Route::post('user/avatar','Api\UserController@avatar');
    Route::get('bankcard/show','Api\BankcardController@show');
    Route::post('bankcard/create','Api\BankcardController@create');
    Route::post('account/withdrawal','Api\AccountController@withdrawal');
    Route::get('qiniu/avatarToken','Api\Qiniucontroller@getAvatarToken');//上传头像获取七牛token
    Route::get('account/index','Api\AccountController@index');
    Route::get('invite','Api\InviteController@Index');
    Route::get('order','Api\OrderController@index');
});

