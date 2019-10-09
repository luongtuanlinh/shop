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

Route::name('guest.')->group(function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/introduction', 'HomeController@introduction')->name('introduction');
    Route::get('/contact', 'HomeController@contact')->name('contact');
    Route::get('/products','HomeController@product')->name('product');
    Route::get('/sale-off','HomeController@saleoff')->name('saleoff');
});


