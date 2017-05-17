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

MoreRoute::controller('auth', 'AuthController');

Route::group(['middleware' => ['authcheck', 'globalviewshare']], function () {
	Route::get('task_files/{filename}', function ($filename){
		$path = storage_path('app') . '/task_files/' . $filename;

		if(!File::exists($path)) abort(404);

		$file = File::get($path);
		$type = File::mimeType($path);

		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);

		return $response;
	});

	MoreRoute::controller('dashboard', 'DashboardController');
	MoreRoute::controller('project', 'ProjectController');
	MoreRoute::controller('task', 'TaskController');
	MoreRoute::controller('user', 'UserController');
});
