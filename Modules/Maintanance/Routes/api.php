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

Route::group(['middleware' => 'auth:api', 'prefix' => 'maintanance'], function () {
    Route::get('getAssetListByJobstation', 'MaintananceController@getAssetListByJobstation');
    Route::get('getPlannedAssetListByJobstation', 'MaintananceController@getPlannedAssetListByJobstation');
    Route::get('getBreakDownAssetListByJobstation', 'MaintananceController@getBreakDownAssetListByJobstation');
    Route::get('getServiceNameListByWareHouse', 'MaintananceController@getServiceNameListByWareHouse');
    Route::post('postMaintenanceEntry', 'MaintananceController@postMaintenanceEntry');
    Route::get('getMaintenanceReportByReqID', 'MaintananceController@getMaintenanceReportByReqID');
    Route::get('getMaintenanceReportByUnit', 'MaintananceController@getMaintenanceReportByUnit');
    Route::get('getMaintenanceJobCard', 'MaintananceController@getMaintenanceJobCard');
    Route::get('getMaintenanceWHList', 'MaintananceController@getMaintenanceWHList');
});
