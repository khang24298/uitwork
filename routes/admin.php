<?php 

// Admin Route
use Illuminate\Support\Facades\Route;









Route::namespace('Admin')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::post('/login', 'LoginController@login')->name('admin.login');
    Route::group(['middleware' => ['auth:admins']], function () {
        Route::get('/home', 'HomeController@index')->name('admin.home');
    });
 });


?>