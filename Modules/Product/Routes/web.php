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
        Route::get('/product/get', 'ProductController@get')->name('product.product.get')->middleware(['verify.role:show']);

        Route::get('/product/getchoose', 'ProductController@getDataChoose')->name('product.product.get_choose');

        Route::get('/product/choose/{cate_id}', 'ProductController@chooseData')->name('product.product.choose_poduct');

        Route::resource('product', 'ProductController', ['as' => 'product']);
        
        Route::get('/product/delete/{id}', 'ProductController@destroy')->name('product.product.delete')->middleware(['verify.role:destroy']);;

        Route::resource('category', 'CategoryController', ['as' => 'product']);

        Route::post('/category/edit', 'CategoryController@editCategory')->name('product.category.editcate')->middleware(['verify.role:editCategory']);

        Route::post('/category/delete', 'CategoryController@deleteCategory')->name('product.category.deleteCate')->middleware(['verify.role:deleteCategory']);

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
                Route::get('/get_color', 'ColorsController@getListColor')->name('product.color.list_color')->middleware(['verify.role:show']);

                Route::post('/create', 'ColorsController@store')->name('product.color.create')->middleware(['verify.role:create']);

                Route::get('edit/{id}', 'ColorsController@edit')->name('product.color.edit')->middleware(['verify.role:edit']);

                Route::post('update', 'ColorsController@update')->name('product.color.update')->middleware(['verify.role:edit']);

                Route::get('delete/{id}', 'ColorsController@destroy')->name('product.color.delete')->middleware(['verify.role:destroy']);
        });

});
