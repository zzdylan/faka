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

});