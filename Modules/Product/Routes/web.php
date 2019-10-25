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
Route::get('/product/get', 'ProductController@get')->name('product.product.get');

Route::get('/product/getchoose', 'ProductController@getDataChoose')->name('product.product.getChoose');

Route::get('/size/get', 'SizeController@get')->name('product.size.get');

Route::group(['middleware' => ['web'], 'prefix' => 'admin'], function()
{
    Route::group(['middleware' => ['auth', 'verify.role']], function () {

        Route::resource('product', 'ProductController', ['as' => 'product']);

        Route::get('/product/delete', 'ProductController@deleteProduct')->name('product.product.deleteProduct');

        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate');

        Route::post('/category/delete', 'CategoryController@deleteCategory')->name('product.category.deleteCate');

        Route::resource('size', 'SizeController', ['as' => 'product']);

        Route::get('/size/getGoogle', 'SizeController@getDataFromSheet')->name('product.size.getGoogle');

        Route::match(['get', 'post'], 'choose', 'ProductController@getChooseProduct')->name('product.choose');

        Route::post('/product/choose', 'ProductController@updateChoosen')->name('product.product.updateChoosen');

    });
});
