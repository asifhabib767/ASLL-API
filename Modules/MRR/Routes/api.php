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


Route::group(['middleware' => 'auth:api', 'prefix' => 'mrr'], function () {
    // Mater Data
    Route::get('getPOType', 'MRRController@getPOType');
    Route::post('storeMRR', 'MRRController@storeMRR');
    Route::get('getOthersInfo', 'MRRController@getOthersInfo');
    Route::get('getSupplierExistence', 'MRRController@getSupplierExistence');
    Route::get('getPOList', 'MRRController@getPOList');
    Route::get('getPOVsWHNExchangrRate', 'MRRController@getPOVsWHNExchangrRate');
    Route::get('getPOVSItemDet', 'MRRController@getPOVSItemDet');
    Route::get('getPOVSItemDetForExport', 'MRRController@getPOVSItemDetForExport');
    Route::get('getwhStoreLocation', 'MRRController@getwhStoreLocation');
    Route::get('getwhItemList', 'MRRController@getwhItemList');
    Route::get('getStoreReqSupvAprvPendingTopSheet', 'MRRController@getStoreReqSupvAprvPendingTopSheet');
    Route::get('GetPendingDataforDeptHeadAprvdetails', 'MRRController@GetPendingDataforDeptHeadAprvdetails');
    Route::get('Getrequisitionwhichareunapproved', 'MRRController@Getrequisitionwhichareunapproved');
    Route::get('GetrequisitionDetailswhichareunapproved', 'MRRController@GetrequisitionDetailswhichareunapproved');
    Route::get('getItemListByWearhouseAndBalance', 'MRRController@getItemListByWearhouseAndBalance');


    // Entry, Update Purchase Requisition

});
