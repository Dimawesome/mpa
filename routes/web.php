<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('page/{slug}/{puid}/{muid?}', 'DashboardController@page');

// Files
Route::get('/files/file/{id}/{name?}', 'FileController@getFile')
    ->where('name', '(.*)');

Route::get('/files/thumbs/{id}/{name?}', 'FileController@getThumb');

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
            Route::get('/menu/create', 'MenuItemController@create');
            Route::post('/menu/store', 'MenuItemController@store');
            Route::get('/menu/edit/{muid}', 'MenuItemController@edit');
            Route::patch('/menu/update', 'MenuItemController@update');
            Route::get('/menu/delete/{muid}', 'MenuItemController@delete');

            // Pages
            Route::get('/pages', 'PageController@index')->name('admin.page');
            Route::get('/pages/listing/{page?}', 'PageController@listing');
            Route::get('/pages/create/{puid?}', 'PageController@create');
            Route::post('/pages/store', 'PageController@store');
            Route::get('/pages/edit/{puid}', 'PageController@edit');
            Route::patch('/pages/update', 'PageController@update');
            Route::get('/pages/remove/{puid}', 'PageController@remove');
            Route::get('/pages/disable/{puid}', 'PageController@disable');
            Route::get('/pages/enable/{puid}', 'PageController@enable');
            Route::get('/pages/trash', 'PageController@trash')->name('admin.page.trash');
            Route::get('/pages/trash/listing', 'PageController@trashListing');
            Route::get('/pages/delete/{puid}', 'PageController@delete');
            Route::get('/pages/delete-all', 'PageController@deleteAll');
            Route::get('/pages/restore/{puid}', 'PageController@restore');
            Route::get('/pages/view/{puid}', 'PageController@view');
            Route::get('/pages/preview/{puid}', 'PageController@preview');

            // Modules
            Route::get('/modules/create/{puid}', 'ModuleController@create');
            Route::post('/modules/store/{puid}', 'ModuleController@store');
            Route::get('/modules/edit/{uid}/{name}/{puid}', 'ModuleController@edit');
            Route::patch('/modules/update/{puid}', 'ModuleController@update');
            Route::get('/modules/enable/{uid}/{name}', 'ModuleController@enable');
            Route::get('/modules/disable/{uid}/{name}', 'ModuleController@disable');
            Route::get('/modules/delete/{uid}/{name}', 'ModuleController@delete');
            Route::get('/modules/view/{uid}/{name}/{puid}', 'ModuleController@view');
            Route::post('/modules/module', 'ModuleController@getModule');
            Route::get('/modules/list/{puid?}', 'ModuleController@moduleList');
            Route::post('/modules/file-list', 'ModuleController@fileList');
            Route::post('/modules/sort', 'ModuleController@sort');
        });
    });
});
