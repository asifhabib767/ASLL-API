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

Route::group(['middleware' => 'auth:api', 'prefix' => 'supplier'], function () {
    Route::get('getSupplierList', 'SupplierController@getSupplierList');
    Route::get('getSupplierListForBridgeToTerritory', 'SupplierController@getSupplierListForBridgeToTerritory');
    Route::get('getVehicleAcceptStatus', 'SupplierController@getVehicleAcceptStatus');
    Route::get('getPoMrrInvoiceStatus', 'SupplierController@getPoMrrInvoiceStatus');
    Route::get('getSupplierBalance', 'SupplierController@getSupplierBalance');
    Route::get('getUnitForSupplier', 'SupplierController@getUnitForSupplier');
});
