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
    return redirect('dashboard');
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

	// ProjectController Routes
	Route::get('project', 'ProjectController@getIndex');
	Route::get('project/dashboard/{id}', 'ProjectController@getDashboard');
	Route::post('project/save-dashboard-locations', 'ProjectController@postSaveDashboardLocations');
	Route::post('project/edit', 'ProjectController@postEdit');
	Route::get('project/edit', 'ProjectController@getEdit');
	Route::post('project/edit/{id}', 'ProjectController@postEdit');
	Route::get('project/edit/{id}', 'ProjectController@getEdit');
	// End of ProjectController Routes

	// TaskController Routes
	Route::post('task/edit', 'TaskController@postEdit');
	Route::get('task/edit', 'TaskController@getEdit');
	Route::post('task/edit/{id}', 'TaskController@postEdit');
	Route::get('task/edit/{id}', 'TaskController@getEdit');
	Route::post('task/view/{id}', 'TaskController@postView');
	Route::get('task/view/{id}', 'TaskController@getView');
	Route::get('task/{id}', 'TaskController@getIndex');
	// End of TaskController Routes

});
