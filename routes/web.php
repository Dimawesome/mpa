<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index');


Route::group(['namespace' => 'Admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/', 'AdminController@index');
        });

        Route::get('/login', 'AdminController@login')->name('admin.login');
        Route::post('/login', 'AdminController@login');
        Route::post('/logout', 'AdminController@logout')->name('admin.logout');
    });
});
