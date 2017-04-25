<?php

use Illuminate\Http\Request;

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

// webhook for bitbucket
Route::post('hook/bitbucket', 'HookController@bitbucket');
Route::post('hook/github', 'HookController@github');
// end webhook for bitbucket
