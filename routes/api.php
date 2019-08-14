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

Route::get('goods','GoodsController@index');
Route::get('card_goods','GoodsController@getByCardType');
Route::get('goods/{goods}','GoodsController@show');
Route::post('orders','OrderController@store');
Route::get('orders','OrderController@index');
Route::post('orders/data/{order}','OrderController@data');
Route::get('orders/{order}','OrderController@show');
Route::post('upload','UploadController@store');
Route::any('notify','NotifyController@payjs');