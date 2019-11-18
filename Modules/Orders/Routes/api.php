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
        Route::group([], function (){
            Route::post('list/order', 'OrderController@listOrders');
            Route::get('/order/view/{id}', 'OrderController@view');
            Route::post('/order/edit', 'OrderController@editOrder');
            Route::post('createOrder', 'OrderController@createOrder');
            Route::get('/customer/search', 'CustomerController@search');
        });
    });
});
