<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/product', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function () {

    Route::group(['prefix' => 'product'], function () {

        Route::get('/', 'ProductController@getProductForTopic');

        Route::post('/all', 'ProductController@getProduct');

        Route::get('/detail/{id}', 'ProductController@getDetaiProduct');
        
    });

    Route::get('/size_color', 'ProductController@getSizeColor');

    Route::group(['prefix' => 'category'], function () {

        Route::get('/product/{id}', 'ProductController@getProductByCategory');

        Route::get('/', 'ProductController@getCategory');

        Route::get('/get_cate/{id}', 'ProductController@getCategoryById');

    });
});

