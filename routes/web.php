<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['site_open_if']],function(){
    Route::get('/', 'IndexController@index');
    Route::get('/select_goods', 'IndexController@selectGoods');
    Route::get('/query_orders', 'IndexController@queryOrders');
    Route::get('/orders/{id}', 'OrderController@pay')->middleware('wechat.oauth');
});