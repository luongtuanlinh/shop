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

    Route::group(['prefix' => 'v1/product'], function () {

        Route::post('/', 'ProductController@getProductForTopic');

        Route::post('/all', 'ProductController@getProduct');

        Route::post('/detail', 'ProductController@getDetaiProduct');
        
    });

    Route::post('v1/size_color', 'ProductController@getSizeColor');

    Route::group(['prefix' => 'v1/category'], function () {

        Route::post('/product', 'ProductController@getProductByCategory');

        Route::post('/', 'ProductController@getCategory');

        Route::post('/get_cate', 'ProductController@getCategoryById');

    });
});

