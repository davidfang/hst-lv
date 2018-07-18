<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'domain' => config('admin.route.domain'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('user','UserController');
    $router->resource('banner','BannerController');
    $router->resource('goods-category','GoodsCategoryController');
    $router->group([
        'prefix' => 'api'
    ],function (){
        Route::get('parent-goods-category','ApiController@parentGoodsCategory');
    });

});
