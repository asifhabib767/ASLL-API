<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
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

Route::group(['prefix' => 'auth'], function () {

    Route::post('superuser-login', 'LoginController@masterLogin');
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');
    Route::post('generate-token', 'LoginController@externalUserLogin');
    // External User Login
    Route::post('external-login', 'LoginController@externalLogin');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('getUserProfile', 'AuthController@getUserProfile');
        Route::put('updateUserProfile', 'AuthController@updateUserProfile');
        Route::delete('deleteUserAccount', 'AuthController@deleteUserAccount');
        Route::post('external-change-password', 'LoginController@changePassword');
    });
});

Route::get('checkInADAuthorized', 'AuthController@checkInADAuthorized');
