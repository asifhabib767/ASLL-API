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

Route::group(['middleware' => 'auth:api', 'prefix' => 'accounts'], function () {
    Route::get('getCostCenterByUnitId', 'CostCenterController@getCostCenterByUnitId');
    Route::get('getOnlineBankListByUnitID', 'AccountsController@getOnlineBankListByUnitID');
    Route::get('getOnlineDepositMode', 'AccountsController@getOnlineDepositMode');
    Route::post('postDepositNItemInformationByApps', 'AccountsController@postDepositNItemInformationByApps');
    Route::get('getDepositInformationByCustomer', 'AccountsController@getDepositInformationByCustomer');
    Route::get('getDepositInformationByUnit', 'AccountsController@getDepositInformationByUnit');
});
