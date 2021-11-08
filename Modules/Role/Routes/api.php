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

Route::group(['middleware' => 'auth:api', 'prefix' => 'roles'], function () {
    Route::get('getModulePermissionByUserTypeID', 'RoleController@getModulePermissionByUserTypeID');
    Route::get('getModulePermissionByUser', 'RoleController@getModulePermissionByUser');
    Route::get('getUserTypeList', 'RoleController@getUserTypeList');
    Route::get('getModuleList', 'RoleController@getModuleList');
    Route::post('appPermissionStore', 'RoleController@appPermissionStore');
    Route::post('multipleAppPermissionStore', 'RoleController@multipleAppPermissionStore');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'roles'], function () {
    Route::post('check-permission', 'PermissionController@checkPermission');
    Route::post('give-permission', 'PermissionController@givePermission');
});
