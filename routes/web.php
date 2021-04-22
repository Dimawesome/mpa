<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index');


Route::group(['namespace' => 'Admin'], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/login', 'AdminController@login')->name('admin.login');
        Route::post('/login', 'AdminController@login');
        Route::post('/logout', 'AdminController@logout')->name('admin.logout');

        Route::group(['middleware' => ['auth']], function () {

            Route::get('/', 'AdminController@index')->name('admin');

            // Menu
            Route::get('/menu', 'MenuItemController@index')->name('admin.menu');
            Route::post('/menu/sort', 'MenuItemController@sort');
            Route::get('/menu/delete/{muid}', 'MenuItemController@delete');
            Route::get('/menu/create', 'MenuItemController@create');
            Route::post('/menu/store', 'MenuItemController@store');
            Route::get('/menu/edit/{muid}', 'MenuItemController@edit');
            Route::patch('/menu/update/{muid}', 'MenuItemController@update');
        });
    });
});
