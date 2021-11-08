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

Route::group(['middleware' => 'auth:api', 'prefix' => 'sales'], function () {
    Route::post('storeSalesOrderEntry', 'SalesController@storeSalesOrderEntry');
    Route::get('getDataVehicleTypeVsVehicleList', 'SalesController@getDataVehicleTypeVsVehicleList');
    Route::get('getTerritoryList', 'SalesController@getTerritoryList');
    Route::get('getDataVehicleInformation', 'SalesController@getDataVehicleInformation');
    Route::get('getDataForCompanyVehicleLabourStatus', 'SalesController@getDataForCompanyVehicleLabourStatus');
    Route::get('getDataForBagType', 'SalesController@getDataForBagType');
    Route::get('getDataForItemList', 'SalesController@getDataForItemList');
    Route::get('getDataForShippingPointByTerritory', 'SalesController@getDataForShippingPointByTerritory');
    Route::get('getDataForCustomerType', 'SalesController@getDataForCustomerType');
    Route::get('getDataForSalesType', 'SalesController@getDataForSalesType');
    Route::get('getDataForECommerceItemPrice', 'SalesController@getDataForECommerceItemPrice');
    Route::get('getDataForThanaName', 'SalesController@getDataForThanaName');
    Route::get('getDataForTotalQntInTrip', 'SalesController@getDataForTotalQntInTrip');
    Route::get('getDataForShippingPointConfiguredForTerritory', 'SalesController@getDataForShippingPointConfiguredForTerritory');
    Route::get('getSalesOrderListByTerritory', 'SalesOrderController@getSalesOrderListByTerritory');
    Route::get('getShippingPointListByUnit', 'SalesController@getShippingPointListByUnit');
    Route::post('addMultipleTerritory', 'SalesController@addMultipleTerritory');
    Route::get('getSalesOffices', 'SalesController@getSalesOffices');
    Route::get('getChartOfAccountData', 'SalesController@getChartOfAccountData');
    Route::get('getSalesOrderProducts', 'SalesController@getSalesOrderProducts');

    Route::get('getCustomerBalanceNUndeliver', 'SalesController@getCustomerBalanceNUndeliver');
    Route::get('getItemWeight', 'SalesController@getItemWeight');
    Route::get('getSalesOrderVsEmployee', 'SalesController@getSalesOrderVsEmployee');
    Route::get('getSalesOrderVsEmployeeforAEL', 'SalesController@getSalesOrderVsEmployeeforAEL');
    Route::get('getCustomersByTSO', 'SalesController@getCustomersByTSO');
    Route::get('getDistributorListByQuery', 'SalesController@getDistributorListByQuery');

    Route::post('storeSalesOrderEntryByCustomer', 'SalesController@storeSalesOrderEntryByCustomer');
    Route::get('GetDONChallanQntUpdate', 'SalesController@GetDONChallanQntUpdate');
    Route::get('getDeliveryRequstDo', 'SalesController@getDeliveryRequstDo');
    Route::get('getDeliveryRequstDo', 'SalesController@getDeliveryRequstDo');

    Route::post('storeSalesOrderEntryByMultipleItem', 'SalesController@storeSalesOrderEntryByMultipleItem');
    Route::post('storeSalesOrderEntryByMultipleItemForUseColumn', 'SalesController@storeSalesOrderEntryByMultipleItemForUseColumn');

    Route::get('getSalesOrderVsItemDetails', 'SalesController@getSalesOrderVsItemDetails');

});
