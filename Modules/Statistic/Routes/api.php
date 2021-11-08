<?php

use Illuminate\Http\Request;
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


Route::group(['middleware' => 'auth:api', 'prefix' => 'statistic'], function () {
    Route::post('storeDeviceRegistration', 'DeviceRegistrationController@storeDeviceRegistration');
    Route::post('sendDeviceNotification', 'DeviceRegistrationController@sendDeviceNotification');
    Route::get('registered-device', 'DeviceRegistrationController@getRegisteredDeviceList');
});
