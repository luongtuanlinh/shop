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
// \URL::forceScheme('https');
Route::group(['middleware' => ['web'], 'prefix' => 'order'], function()
{
    Route::group(['middleware' => ['auth', 'verify.role']], function () {
        Route::get('/', 'OrdersController@index')->name('order.index');
        Route::get('/get', 'OrdersController@get')->name('order.get');
        Route::get('/get/{id}', 'OrdersController@getOrderItems')->name('order.getOrderItems');

        Route::get('/create', 'OrdersController@create')->name('order.create');
        Route::post('/store', 'OrdersController@store')->name('order.store');

        Route::get('/excel', 'OrdersController@excel')->name('order.excel');
        Route::get('/change/status', 'OrdersController@changeStatus')->name('order.change.status');
        Route::get('/view/{id}', 'OrdersController@view')->name('order.view');
        Route::post('/update', 'OrdersController@update')->name('order.update');
        Route::post('/delete', 'OrdersController@delete')->name('order.delete');
    });


});
Route::group(['middleware' => ['web'], 'prefix' => 'customer'], function()
{
    Route::group(['middleware' => ['auth', 'verify.role']], function () {
        Route::get('/', 'CustomerController@index')->name('customer.index');
        Route::get('/get', 'CustomerController@get')->name('customer.get');

        Route::get('/excel', 'CustomerController@excel')->name('customer.excel');
        Route::get('/view/{id}', 'OrdersController@view')->name('order.view');
        Route::get('/search', 'CustomerController@search')->name('customer.search');
        Route::post('/update', 'OrdersController@update')->name('order.update');
        Route::post('/delete', 'OrdersController@delete')->name('order.delete');
    });


});
