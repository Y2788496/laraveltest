<?php

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

Route::get('users/{all?}', 'UsersController@users');

Route::get('user/{user}', 'UsersController@user');
Route::post('user/hide', 'UsersController@hide');

Route::post('search', 'UsersController@search');
