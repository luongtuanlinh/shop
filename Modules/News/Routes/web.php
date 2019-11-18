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

Route::group(['prefix' => 'api/v1', 'namespace' => 'Modules\News\Http\Controllers\Api\V1'], function () {
    Route::post('/login', 'UserController@Login')->name('api.v1.core.login');
    Route::group([], function () {
        //Posts
        Route::post('/news/categories', 'NewsController@listCategories')->name('api.v1.news.categories');
        Route::post('/news/posts', 'NewsController@listPosts')->name('api.v1.news.posts');
        Route::post('/news/detailPost', 'NewsController@detailPost')->name('api.v1.news.detail');
    
        Route::post('/news/detailPostV2', 'NewsController@detailPostV2')->name('api.v1.news.detail');
        
        Route::post('/news/rootCategory','NewsController@rootCategory')->name('api.v1.news.root');
        //Block
        Route::post('/news/block', 'BlocksController@Block')->name('api.v1.news.block');
        
        // Comment
        Route::post('/comment/list', 'CommentController@getList')->name('api.v1.news.comment.list');
        Route::post('/comment/add', 'CommentController@add')->name('api.v1.news.comment.add');
    });
});
