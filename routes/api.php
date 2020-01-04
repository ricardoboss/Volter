<?php

/*
 * Copyright (C) 2019 Ricardo Boss
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
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
    Route::get('check', 'VerificationController@check')->name('verification.notice');
    Route::get('verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('resend', 'VerificationController@resend')->name('verification.resend');
});
