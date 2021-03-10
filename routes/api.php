<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'APIController@login');
Route::group(['middleware' => 'auth.jwt'], function () {
    // dd(Auth::user());
    Route::get('logout', 'APIController@logout');
    Route::get('users', 'UserController@index');
    Route::resource('/task','TaskController');

    // Route::get('/dashboard', 'DashboardController@create');

    Route::get('/projects', 'ProjectsController@index');

    Route::get('/projects/create', 'ProjectsController@create');

    Route::get('/projects/{project}', 'ProjectsController@show');

    Route::post('/projects', 'ProjectsController@store');

    Route::get('/projects/{project}/edit', 'ProjectsController@edit');

    Route::put('/projects/{project} ', 'ProjectsController@update');
});