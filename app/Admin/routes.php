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

    $router->any('/taobao/selection', 'TaobaoController@selection');
    $router->get('/taobao/executeUpdate/{favorites_id?}/{page_no?}', 'TaobaoController@executeUpdate')->name('taobao.execute_update');
    $router->post('/taobao/executeOne', 'TaobaoController@executeOne');
    $router->get('/taobao/coupon', 'TaobaoController@coupon');
    $router->get('/taobao/item/{id}', 'TaobaoController@item');
    $router->resource('goods',GoodsController::class);
    $router->resource('goods-taobao','GoodsTaobaoController');
    $router->resource('search-log','DgSearchController');
    $router->group([
        'prefix' => 'api'
    ],function (){
        Route::get('parent-goods-category','ApiController@parentGoodsCategory');
        Route::get('refresh-goods-category','ApiController@refreshGoodsCategory');
    });

});
