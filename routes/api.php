<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 商品追加
Route::post('/products', 'ProductController@create')->name('product.create');