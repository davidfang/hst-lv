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
Route::get('/banner/index', 'BannerController@index');
Route::get('/banner/show/{banner}', 'BannerController@show');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login','AuthenticateController@login');

Route::post('passport/login','Api\Auth\LoginController@login');
Route::post('passport/register','Api\Auth\RegisterController@register');



