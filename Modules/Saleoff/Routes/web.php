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

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::prefix('/saleoff')->name('saleoff.')->group(function () {
        Route::get('/', 'SaleoffController@index')->name('index')->middleware(['verify.role:show']);
        Route::get('/get', 'SaleoffController@get')->name('get')->middleware(['verify.role:show']);
        Route::get('/create', 'SaleoffController@create')->name('create')->middleware(['verify.role:create']);
        Route::post('/store', 'SaleoffController@store')->name('store')->middleware(['verify.role:create']);
        Route::get('/{id}/edit/', 'SaleoffController@edit')->name('edit')->middleware(['verify.role:edit']);
        Route::post('/{id}/update', 'SaleoffController@update')->name('update')->middleware(['verify.role:edit']);
        Route::delete('/destroy', 'SaleoffController@destroy')->name('destroy')->middleware(['verify.role:destroy']);
    });
});

Route::prefix('/api')->group(function () {
    Route::prefix('/saleoff')->name('saleoff')->group(function () {
        Route::get('/', 'SaleoffController@client')->name('client');
    });
});
