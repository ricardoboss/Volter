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

Route::group(['prefix' => 'auth'], function (): void {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['prefix' => 'passwords'], function (): void {
    Route::get('', 'PasswordController@index');
    Route::post('', 'PasswordController@create');

    Route::get('{password}', 'PasswordController@view');
    Route::put('{password}', 'PasswordController@update');
    Route::delete('{password}', 'PasswordController@delete');
    Route::delete('{password}/destroy', 'PasswordController@destroy');

    Route::put('{password}/share', 'PasswordController@share');
});

Route::group(['prefix' => 'users'], function (): void {
    Route::get('', 'UserController@index');
    Route::post('', 'UserController@create')->middleware('can:create,App\Models\User');

    Route::get('{user}', 'UserController@view')->middleware('can:view,user');
    Route::put('{user}', 'UserController@update')->middleware('can:update,user');
    Route::delete('{user}', 'UserController@delete')->middleware('can:delete,user');
});

Route::group(['prefix' => 'email'], function (): void {
    Route::get('verify', 'VerificationController@check')->name('verification.notice');
    Route::get('verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('resend', 'VerificationController@resend')->name('verification.resend');
});
