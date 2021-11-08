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


Route::group(['middleware' => 'auth:api', 'prefix' => 'purchaseRequisition'], function () {
    // Mater Data
    Route::get('getWearehouseList', 'WearehouseController@getWearehouseList');
    Route::get('getWearehouseListByEmployeePermissionForStore', 'WearehouseController@getWearehouseListByEmployeePermissionForStore');
    Route::get('getWearehouseListByEmployeePermissionForRequisition', 'WearehouseController@getWearehouseListByEmployeePermissionForRequisition');
    Route::get('getWearehouseListByEmployeePermissionForRequisition', 'WearehouseController@getWearehouseListByEmployeePermissionForRequisition');
    Route::get('getWearehouseListByEmployeePermissionForIndent', 'WearehouseController@getWearehouseListByEmployeePermissionForIndent');
    Route::get('getWearehouseListByEmployeePermissionForIndentApproval', 'WearehouseController@getWearehouseListByEmployeePermissionForIndentApproval');
    Route::get('getWearehouseListByEmployeePermissionForPO', 'WearehouseController@getWearehouseListByEmployeePermissionForPO');

    Route::get('getInventoryPermissions', 'WearehouseController@getInventoryPermissions');
    Route::get('getDepartmentList', 'DepartmentsController@getDepartmentList');
    Route::get('getItemListByUnit', 'ItemsController@getItemListByUnit');
    Route::get('getItemListAll', 'ItemsController@getItemListAll');
    Route::get('getItemTypeListAll', 'ItemTypesController@getItemTypeListAll');
    Route::get('getWareHouseInformation', 'WearehouseController@getWareHouseInformation');
    // Route::get('getItemCategoryListByUnit', 'ItemCategoriesController@getItemCategoryListByUnit');

    // Purchase Details
    Route::get('getPurchaseListDetailsByPurchaseId', 'PurchaseRequisitionController@getPurchaseListDetailsByPurchaseId');
    Route::get('getPurchaseListByUnitId', 'PurchaseRequisitionController@getPurchaseListByUnitId');
    Route::get('getPurchaseListByUserId', 'PurchaseRequisitionController@getPurchaseListByUserId');
    Route::get('getPurchaseApproveListByUserId', 'PurchaseRequisitionController@getPurchaseApproveListByUserId');
    Route::get('getPurchaseRejectListByUserId', 'PurchaseRequisitionController@getPurchaseRejectListByUserId');

    // Entry, Update Purchase Requisition
    Route::post('storePurchaseRequisition', 'PurchaseRequisitionController@storePurchaseRequisition');
    Route::put('updatePurchaseRequisition', 'PurchaseRequisitionController@updatePurchaseRequisition');

    //purchase requisition upload file
    Route::post('fileInput', 'PurchaseRequisitionFileUploadController@fileInput');

    //unit list
    Route::get('getUnitList', 'UnitController@getUnitList');
});
