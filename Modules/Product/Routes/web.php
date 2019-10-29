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


Route::get('/size/get', 'SizeController@get')->name('product.size.get');

Route::group(['middleware' => ['web', 'auth', 'verify.role'], 'prefix' => 'admin'], function()
{
        Route::get('/product/get', 'ProductController@get')->name('product.product.get');

        Route::get('/product/getchoose', 'ProductController@getDataChoose')->name('product.product.getChoose');

        Route::resource('product', 'ProductController', ['as' => 'product']);
        
        Route::get('/product/delete/{id}', 'ProductController@destroy')->name('product.product.delete');

        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate');

        Route::post('/category/delete', 'CategoryController@deleteCategory')->name('product.category.deleteCate');

        Route::resource('size', 'SizeController', ['as' => 'product']);

        Route::get('/size/getGoogle', 'SizeController@getDataFromSheet')->name('product.size.getGoogle');

        Route::match(['get', 'post'], 'choose', 'ProductController@getChooseProduct')->name('product.choose');

        Route::post('/product/choose', 'ProductController@updateChoosen')->name('product.product.updateChoosen');

        Route::group(['prefix' => 'color'], function() {

                //route for product_color                

                Route::get('/{id}/amount', 'ColorsController@index')->name('product.color.get');

                Route::get('/get', 'ColorsController@get')->name('product.color.getData');

                Route::match(['get', 'post'], '/add_amount/{id}', 'ColorsController@createAmount')->name('product.color.create_amount');

                Route::match(['get', 'post'], '/edit_amount', 'ColorsController@editAmount')->name('product.color.edit_amount');

                Route::get('delete_amount/{id}', 'ColorsController@deleteAmount')->name('product.color.delete_amount');

                // route for color
                Route::get('/get_color', 'ColorsController@getListColor')->name('product.color.list_color');

                Route::post('/create', 'ColorsController@store')->name('product.color.create');

                Route::get('edit/{id}', 'ColorsController@edit')->name('product.color.edit');

                Route::post('update', 'ColorsController@update')->name('product.color.update');

                Route::get('delete/{id}', 'ColorsController@destroy')->name('product.color.delete');
        });

});
