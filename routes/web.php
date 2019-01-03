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

Route::group(['prefix' => 'wechat_menus'], function () {
    Route::view('/panel', 'wechatMenu');
    Route::get('/', 'WechatMenuController@index');
    Route::post('/', 'WechatMenuController@store');
    Route::delete('/', 'WechatMenuController@destroy');
});
Route::get('/', 'IndexController@index');
Route::get('/select_goods', 'IndexController@selectGoods');
Route::get('/query_orders', 'IndexController@queryOrders');
Route::get('/orders/{id}/pay', 'OrderController@pay');
Route::get('test', function () {
    $orders = \App\Models\Order::where('type',1)->where('pay_account','527844046')->paginate(15);
    dd($orders);
    return view('home.test');
});