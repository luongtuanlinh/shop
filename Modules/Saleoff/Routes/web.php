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

Route::prefix('/admin')->name('admin.')->group(function(){
   Route::prefix('/saleoff')->name('saleoff.')->group(function(){
       Route::get('/','SaleoffController@index')->name('index');
       Route::get('/create','SaleoffController@create')->name('create');
       Route::post('/store','SaleoffController@store')->name('store');
       Route::delete('/destroy','SaleoffController@destroy')->name('destroy');

   });
});

Route::prefix('/api')->group(function(){

});