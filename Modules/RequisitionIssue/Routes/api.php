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

Route::group(['middleware' => 'auth:api', 'prefix' => 'requisitionIssue'], function () {
    Route::get('getStoreIssueListByUnitId', 'RequisitionIssueController@getStoreIssueListByUnitId');

    Route::post('storeIssue', 'RequisitionIssueController@storeIssue');
    Route::post('postFuelRequisitionEntry', 'RequisitionIssueController@postFuelRequisitionEntry');
    Route::get('getStoreIssueListByWareHouseId', 'RequisitionIssueController@getStoreIssueListByWareHouseId');
    Route::get('getStoreIssueRequisitionDetaills', 'RequisitionIssueController@getStoreIssueRequisitionDetaills');
    Route::get('getDataExistOrNotExistInInventory', 'RequisitionIssueController@getDataExistOrNotExistInInventory');
    Route::get('getDataExistencyInInventoryRunningBalance', 'RequisitionIssueController@getDataExistencyInInventoryRunningBalance');
    Route::post('storeIssueTblInventoryRunningBalance', 'RequisitionIssueController@storeIssueTblInventoryRunningBalance');

    Route::get('getCustomerLoadingProfile', 'RequisitionIssueController@getCustomerLoadingProfile');
    Route::get('getItemVsDamage', 'RequisitionIssueController@getItemVsDamage');
    Route::get('getSalesOfficeVsDiscount', 'RequisitionIssueController@getSalesOfficeVsDiscount');
    Route::post('DeliveryRequisition', 'RequisitionIssueController@storeDeliveryRequisition');
    Route::post('ShipmentPlanningSubmit', 'RequisitionIssueController@storeShipmentPlanningSubmit');
});
