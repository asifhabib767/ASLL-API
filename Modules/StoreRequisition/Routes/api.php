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

Route::group(['middleware' => 'auth:api', 'prefix' => 'storeRequisition'], function () {
    // Store Requisition
    Route::get('getStoreListByUnitId', 'StoreRequisitionController@getStoreListByUnitId');
    Route::get('getStoreRequisitionListForIssue', 'StoreRequisitionController@getStoreRequisitionListForIssue');
    Route::get('getStoreRequisitionByEmployee', 'StoreRequisitionController@getStoreRequisitionByEmployee');
    Route::get('getStoreRequisitionDetailsByRequisitionId', 'StoreRequisitionController@getStoreRequisitionDetailsByRequisitionId');
    Route::post('postStoreRequisitionEntry', 'StoreRequisitionController@postStoreRequisitionEntry');
    Route::put('updateAndApproveRequisitionEntry', 'StoreRequisitionController@updateAndApproveRequisitionEntry');
    Route::get('getAssetListByJobstation', 'StoreRequisitionController@getAssetListByJobstation');
});
