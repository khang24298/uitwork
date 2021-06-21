<?php

// Admin Route
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;

Route::namespace('Admin')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::post('/login', 'LoginController@login')->name('admin.login');

    // Middleware.
    Route::middleware(['admin'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('admin.home');
        Route::get('/dashboard', 'HomeController@dashboard')->name('admin.dashboard');
        Route::get('/test', 'HomeController@test')->name('admin.test');

        // PermissionGroup
        Route::prefix('permission-group')->group(function() {
            Route::get('/', 'GroupPermissionController@index')->name('group.permission.index');
            Route::get('/add', 'GroupPermissionController@create')->name('group.permission.add');
            Route::post('/add', 'GroupPermissionController@store')->name('group.permission.store');

            Route::get('/edit/{id}', 'GroupPermissionController@edit')->name('group.permission.edit');
            Route::put('/edit/{id}', 'GroupPermissionController@update')->name('group.permission.update');

            Route::get('/delete/{id}', 'GroupPermissionController@destroy')->name('group.permission.delete');
        });

        // Permission
        Route::prefix('permission')->group(function() {
            Route::get('/', 'PermissionController@index')->name('permission.index');
            Route::get('/add', 'PermissionController@create')->name('permission.add');
            Route::post('/add', 'PermissionController@store')->name('permission.store');

            Route::get('/edit/{id}', 'PermissionController@edit')->name('permission.edit');
            Route::put('/edit/{id}', 'PermissionController@update')->name('permission.update');

            Route::get('/delete/{id}', 'PermissionController@destroy')->name('permission.delete');
        });

        // Role
        Route::prefix('role')->group(function() {
            Route::get('/', 'RoleController@index')->name('role.index');
            Route::get('/add', 'RoleController@create')->name('role.add');
            Route::post('/add', 'RoleController@store')->name('role.store');

            Route::get('/edit/{id}', 'RoleController@edit')->name('role.edit');
            Route::put('/edit/{id}', 'RoleController@update')->name('role.update');

            Route::get('/delete/{id}', 'RoleController@destroy')->name('role.delete');
        });

        // User
        Route::prefix('user')->group(function() {
            Route::get('/', 'UserController@index')->name('user.index');
            Route::get('/add', 'UserController@create')->name('user.add');
            Route::post('/add', 'UserController@store')->name('user.store');

            Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
            Route::put('/edit/{id}', 'UserController@update')->name('user.update');

            Route::get('/delete/{id}', 'UserController@destroy')->name('user.delete');
        });
    });
});

