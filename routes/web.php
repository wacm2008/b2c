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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//商品展示
Route::get('/goodslist', 'GoodsController@index');
Route::get('/goodsdetail/{goods_id}', 'GoodsController@goodsdetail');
//购物车
Route::post('/carAdd','CarController@carAdd');
Route::get('/carlist','CarController@carlist');
Route::post('/totalPrice','CarController@totalPrice');
Route::post('/changeNum','CarController@num');
//订单
Route::get('/orderAdd','OrderController@orderAdd');