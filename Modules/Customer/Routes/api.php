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

Route::group(['middleware' => 'auth:api', 'prefix' => 'customer'], function () {
    Route::get('getCustomerVsShopInfo', 'CustomerController@getCustomerVsShopInfo');
    Route::get('getCustomerVsSalesOrder', 'CustomerController@getCustomerVsSalesOrder');
    Route::get('getUnitvsShopSearching', 'CustomerController@getUnitvsShopSearching');
    Route::get('getSalesOfficevsShopList', 'CustomerController@getSalesOfficevsShopList');
    Route::get('getShopListLocationUpdatestatus', 'CustomerController@getShopListLocationUpdatestatus');
    Route::get('getShopListLocationUpdatestatus', 'CustomerController@getShopListLocationUpdatestatus');
    Route::get('getShopListReportConfiguration', 'CustomerController@getShopListReportConfiguration');
    Route::get('getCustomerPendingSalesOrderList', 'CustomerController@getCustomerPendingSalesOrderList');
    Route::get('getManpowerGeoLevel', 'CustomerController@getManpowerGeoLevel');
    Route::get('getRetaillerCoverage', 'CustomerController@getRetaillerCoverage');
    Route::get('getCustomerbalanceInformation', 'CustomerBalanceController@getCustomerbalanceInformation');
    Route::get('getSupportInformationForAPPSUser', 'CustomerController@getSupportInformationForAPPSUser');
    Route::get('getProductPriceByCustomer', 'CustomerController@getProductPriceByCustomer');
    Route::get('getCustomerVsShopInfoByEmail', 'CustomerController@getCustomerVsShopInfoByEmail');
    Route::get('getProductPriceByCustomerFunction', 'CustomerController@getProductPriceByCustomerFunction');
    Route::get('getProductPricewithOthersInfo', 'CustomerController@getProductPricewithOthersInfo');
    Route::get('getCustomerStatement', 'CustomerController@getCustomerStatement');
    Route::get('getCustomerVsShopInforLevel3', 'CustomerController@getCustomerVsShopInforLevel3');


});
