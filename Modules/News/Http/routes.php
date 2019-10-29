<?php

Route::group(['middleware' => 'web', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::get('/login', 'AdminController@login')->name('login');
    Route::post('/login', 'AdminController@loginPost')->name('login');
    Route::get('/password/reset/{token?}', 'AdminController@resetPassword');
    Route::post('/password/email', 'AdminController@sendResetLinkEmail')->name('password.email');
    Route::post('/password/reset', 'AdminController@saveNewPassword')->name('password.request');
    Route::get('/forgot_password','AdminController@forgotPassword')->name('forgot_password');

    Route::group(['middleware' => ['auth', 'verify.role'] , 'prefix' => 'news'], function () {
        Route::get('/', 'NewsController@index');

        Route::get('/news_category/checkRegion', 'NewsCategoryController@checkRegion')->name('checkRegion');
        Route::resource('/news_category', 'NewsCategoryController', ['as' => 'news', 'except' => ['delete,update']]);
        Route::get('/news_category/get', 'NewsCategoryController@get')->name('news.news_category.get');
        Route::post('news_category/update/{id}', 'NewsCategoryController@update')->name('news.news_category.update');
        Route::get('news_category/delete/{id}', 'NewsCategoryController@destroy')->name('news.news_category.delete');

        Route::resource('/news_post', 'NewsPostController', ['as' => 'news', 'only' => ['index', 'show', 'create', 'store', 'edit']]);
        Route::post('news_post/update/{id}', 'NewsPostController@update')->name('news.news_post.update');
        Route::get('/news_post/get', 'NewsPostController@get')->name('news.news_post.get');
        Route::get('news_post/delete/{id}', 'NewsPostController@destroy')->name('news.news_post.delete');


        Route::get('/news_region/get', 'RegionController@regionList')->name('news.news_region.get');
        Route::get('/news_region/edit/{id}', 'RegionController@edit')->name('news.news_region.edit');
        Route::get('news_region/checkDelete', 'RegionController@checkDelete');
        Route::resource('/news_region', 'RegionController', ['as' => 'news', 'only' => ['index', 'show', 'create', 'store']]);
        Route::post('news_region/update/{id}', 'RegionController@update')->name('news.news_region.update');
        Route::get('news_region/delete/{id}', 'RegionController@destroy')->name('news.news_region.delete');


        Route::get('/news_block/detail/{id}', 'BlockController@detail')->name('news.block.detail');
        Route::resource('/news_block', 'BlockController', ['as' => 'news', 'only' => ['index', 'show', 'create', 'store', 'edit']]);
        Route::post('news_block/update/{id}', 'BlockController@update')->name('news.block.update');
        Route::get('/lock/getList', 'BlockController@getList')->name('news.block.get');
        Route::get('news_block/delete/{id}', 'BlockController@destroy')->name('news.news_block.delete');
        Route::get('block/test', 'BlockController@test');
        Route::get('/updateShowTitle', 'NewsPostController@updateShowTitle')->name('news.new_post.updateShowTitle');
    });

});

/* API route */
Route::group(['prefix' => 'api/v1', 'namespace' => 'Modules\News\Http\Controllers\Api\V1'], function () {
    Route::post('/login', 'UserController@Login')->name('api.v1.core.login');

    Route::group([ 'middleware'=>'api_check'], function () {
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
