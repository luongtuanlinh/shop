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
Route::middleware('auth:api')->get('/core', function (Request $request) {
    return $request->user();
});
/* API route */
Route::group(['namespace' => 'Api'], function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        //Posts
        Route::post('login', 'UserController@login');
        Route::post('signup', 'UserController@store');
        Route::post('logout', 'UserController@logout');
        Route::post('/user/update', 'UserController@update');
        Route::post('/user/info', 'UserController@getInfo');
    });
});

