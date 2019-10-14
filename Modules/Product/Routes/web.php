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

        Route::post('/product/delete', 'ProductController@deleteProduct')->name('product.product.deleteProduct');

        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate');

        Route::post('/category/delete', 'CategoryController@deleteCategory')->name('product.category.deleteCate');

        Route::resource('size', 'SizeController', ['as' => 'product']);

    });
});
