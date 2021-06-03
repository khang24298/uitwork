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
            // Route::get('/list', function () {
            //     return view('admin.permission_group.list');
            // });
            // Route::get('/add', function () {
            //     return view('admin.permission_group.add');
            // });
            // Route::get('/edit', function () {
            //     return view('admin.permission_group.edit');
            // });
            Route::get('/', 'GroupPermissionController@index')->name('group.permission.index');
            Route::get('/add', 'GroupPermissionController@create')->name('group.permission.add');
            Route::post('/add', 'GroupPermissionController@store');

            Route::get('/edit/{id}', 'GroupPermissionController@edit')->name('group.permission.edit');
            Route::post('/edit/{id}', 'GroupPermissionController@store');

            Route::get('/delete/{id}', 'GroupPermissionController@destroy')->name('group.permission.delete');
        });

        // User
        Route::prefix('user')->group(function() {
            Route::get('/list', function () {
                return view('admin.user.list');
            });
            Route::get('/add', function () {
                return view('admin.user.add');
            });
            Route::get('/edit', function () {
                return view('admin.user.edit');
            });
        });
    });
});

