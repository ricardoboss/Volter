<?php

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

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['prefix' => 'passwords'], function () {
    Route::post('', 'PasswordController@create')->middleware('can:create,App\Models\Post');

    Route::get('{password}', 'PasswordController@view')->middleware('can:view,password');
    Route::put('{password}', 'PasswordController@edit')->middleware('can:edit,password');
    Route::delete('{password}', 'PasswordController@delete')->middleware('can:delete,password');
    Route::delete('{password}/destroy', 'PasswordController@destroy')->middleware('can:destroy,password');

    Route::put('{password}/share', 'PasswordController@share')->middleware('can:share,password');
});
