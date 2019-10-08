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
    Route::get('/login', 'AdminController@login')->name('login');
    Route::post('/login', 'AdminController@loginPost')->name('login');
    Route::get('/password/reset/{token?}', 'AdminController@resetPassword');
    Route::post('/password/email', 'AdminController@sendResetLinkEmail')->name('password.email');
    Route::post('/password/reset', 'AdminController@saveNewPassword')->name('password.request');
    Route::get('/forgot_password','AdminController@forgotPassword')->name('forgot_password');


    Route::group(['middleware' => ['auth', 'verify.role']], function () {
        Route::get('/', 'DashboardController@index')->name('admin_home');

        Route::get('/logout', 'AdminController@logout')->name('admin_logout');

        Route::get('/dashboard', 'DashboardController@index')->name('core.dashboard');
        Route::get('/filler_customer', 'DashboardController@filler_customer')->name('core.filler_customer');



        Route::resource('user', 'UserController', ['as' => 'core']);
        Route::post('/user/{id}/restore', 'UserController@restore')->name('core.user.restore');
        Route::post('/user/{id}/reset_password', 'UserController@resetPassword')->name('core.user.reset_password');
        Route::get('/user/{id}/change_information','UserController@changeInformation')->name('core.user.change_information');
        Route::post('/user/{id}/change_information/update','UserController@updateUserInformation')->name('core.user.update_information');

        Route::resource('role', 'RoleController', ['as' => 'core']);
        Route::post('/role/{id}/restore', 'RoleController@restore')->name('core.role.restore');

        Route::resource('group', 'GroupController', ['as' => 'core']);
        Route::post('/group/{id}/restore', 'GroupController@restore')->name('core.group.restore');

    });
});

