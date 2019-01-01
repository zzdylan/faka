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
Route::get('goods/{goods}','GoodsController@show');
Route::post('orders','OrderController@store');
Route::get('orders/{order}','OrderController@show');