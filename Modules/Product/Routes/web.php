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

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function()
{
    Route::group(['middleware' => ['auth', 'verify.role']], function () {

        // Route::get('/', 'ProductController@index')->name('admin_home');

        Route::resource('product', 'ProductController', ['as' => 'product']);


        Route::resource('sale', 'SaleController', ['as' => 'product']);


        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/add', 'CategoryController@addCategory')->name('product.category.addcate');

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate');

        Route::resource('event', 'EventsController', ['as' => 'product']);

    });
});
