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
    Route::get('/login','HomeController@login')->name('login');

    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/gioi-thieu', 'HomeController@introduction')->name('introduction');
    Route::get('/lien-he', 'HomeController@contact')->name('contact');
    Route::get('/san-pham','HomeController@product')->name('product');
    Route::get('/sale-off','HomeController@saleoff')->name('saleoff');
    Route::get('/tin-tuc','HomeController@news')->name('news');

    Route::get('/chinh-sach-van-chuyen','HomeController@transportPolicy')->name('transport');
    Route::get('/chinh-sach-thanh-toan','HomeController@paymentPolicy')->name('payment');
    Route::get('/chinh-sach-bao-mat','HomeController@securityPolicy')->name('security');
});


