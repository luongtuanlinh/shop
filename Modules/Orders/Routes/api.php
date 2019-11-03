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
Route::middleware('auth:api')->get('/orders', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api'], function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        //Posts
        Route::post('/orders/categories', 'OrderController@listCategories')->name('api.v1.news.categories');
        Route::post('/orders/orders', 'OrderController@listOrders')->name('api.v1.news.orders');
        Route::post('/orders/create', 'OrderController@createOrder')->name('api.v1.orders.create');
    });
});
