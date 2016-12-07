<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//AuthController Routes
Route::post('auth/login', 'AuthController@postLogin');
Route::get('auth/login', 'AuthController@getLogin');
Route::get('auth/logout', 'AuthController@getLogout');
Route::post('auth/forgot-password', 'AuthController@postForgotPassword');
Route::get('auth/forgot-password', 'AuthController@getForgotPassword');
Route::post('auth/forgot-password-confirmation', 'AuthController@postForgotPasswordConfirmation');
Route::get('auth/forgot-password-confirmation', 'AuthController@getForgotPasswordConfirmation');
// End of AuthController Routes

Route::group(['middleware' => 'authcheck'], function () {
	// DashboardController Routes
	Route::get('dashboard', 'DashboardController@getIndex');
	// End of DashboardController Routes
});
