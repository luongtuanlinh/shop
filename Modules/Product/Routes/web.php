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


Route::group(['middleware' => ['web', 'auth', 'verify.role'], 'prefix' => 'admin'], function()
{       
        //route for product

        Route::get('/product/get', 'ProductController@get')->name('product.product.get')->middleware(['verify.role:show']);

        Route::get('/product/getchoose', 'ProductController@getDataChoose')->name('product.product.get_choose');

        Route::get('/product/choose/{cate_id}', 'ProductController@chooseData')->name('product.product.choose_poduct');

        Route::resource('product', 'ProductController', ['as' => 'product']);
        
        Route::get('/product/delete/{id}', 'ProductController@destroy')->name('product.product.delete')->middleware(['verify.role:destroy']);

        Route::post('/product/choose', 'ProductController@updateChoosen')->name('product.product.updateChoosen');

        Route::match(['get', 'post'], 'choose', 'ProductController@getChooseProduct')->name('product.choose');

        //route for category

        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate')->middleware(['verify.role:editCategory']);

        Route::post('/category/delete', 'CategoryController@deleteCategory')->name('product.category.deleteCate')->middleware(['verify.role:deleteCategory']);

});
