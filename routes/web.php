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

Route::group(['prefix'=>'wechat_menus'],function(){
    Route::view('/panel','wechatMenu');
    Route::get('/','WechatMenuController@index');
    Route::post('/','WechatMenuController@store');
    Route::delete('/','WechatMenuController@destroy');
});
Route::get('/','IndexController@index');
Route::get('/orders/{id}/pay','OrderController@pay');
Route::get('test',function(){
    $result = app('youzan')->post('youzan.trades.qr.get', [
        'qr_id' => 10634139,
        'status' => 'TRADE_RECEIVED'
    ]);
    dd($result);
});