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

Route::group(['middleware' => 'auth:api', 'prefix' => 'voyageLighter'], function () {
// Route::group(['prefix' => 'voyageLighter'], function () {
    Route::get('getVoyageLighter', 'VoyageLighterController@getVoyageLighter');
    Route::get('getVoyageLighterDetails/{intVoyageLighterId}', 'VoyageLighterController@getVoyageLighterDetails');
    Route::get('getLighter', 'VoyageLighterController@getLighter');
    Route::get('getVoyageLighterVesselId', 'VoyageLighterController@getVoyageLighterVesselId');
    Route::get('getItemType', 'VoyageLighterController@getItemType');
    Route::get('getLoadingPointType', 'VoyageLighterController@getLoadingPointType');
    Route::get('getLighterStatus', 'VoyageLighterController@getLighterStatus');
    Route::get('getEmployeeList', 'VoyageLighterController@getEmployeeList');
    Route::get('getEmployeeListByLighterId', 'VoyageLighterController@getEmployeeListByLighterId');
    Route::post('voyageLighterStore', 'VoyageLighterController@voyageLighterStore');
    Route::put('voyageLighterUpdate', 'VoyageLighterController@voyageLighterUpdate');
    Route::put('lighterEmployeeUpdate', 'VoyageLighterController@lighterEmployeeUpdate');

    Route::get('getFuelLog', 'FuelLogController@getFuelLog');
    Route::post('fuelLogStore', 'FuelLogController@fuelLogStore');
    Route::put('fuelLogUpdate', 'FuelLogController@fuelLogUpdate');

    Route::get('getLighterVoyageActivity', 'LighterVoyageActivityController@getLighterVoyageActivity');
    Route::post('lighterVoyageActivityStore', 'LighterVoyageActivityController@lighterVoyageActivityStore');
    Route::get('getLighterLoadingPointOrVesselType', 'LighterUnloadController@getLighterLoadingPointOrVesselType');
    Route::post('postlighterVoyageUnloadNStockQntStore', 'LighterUnloadController@postlighterVoyageUnloadNStockQntStore');
    Route::get('getLighterUnloadCategory', 'LighterUnloadController@getLighterUnloadCategory');
    Route::post('postvesselDemandQntStore', 'VesselDemanSheetController@postvesselDemandQntStore');
    Route::post('postvesselDemandQntApproveStore', 'VesselDemanSheetController@postvesselDemandQntApproveStore');
    Route::get('getPendingDataForAprv', 'VesselDemanSheetController@getPendingDataForAprv');
    Route::get('getDemandSheetDetailByID', 'VesselDemanSheetController@getDemandSheetDetailByID');
    Route::get('getShipperList', 'VesselDemanSheetController@getShipperList');
    Route::get('getChartererList', 'VesselDemanSheetController@getChartererList');
    Route::get('getApproveDataDemandSheet', 'VesselDemanSheetController@getApproveDataDemandSheet');
    Route::put('updateApprovedInformationDataDemandSheet', 'VesselDemanSheetController@updateApprovedInformationDataDemandSheet');
    Route::get('getApproveDataByID', 'VesselDemanSheetController@getApproveDataByID');
    Route::get('getLighterVoyageTopsheet', 'LighterVoyageActivityController@getLighterVoyageTopsheet');
    Route::get('getLighterVoyageDetaillsByID', 'LighterVoyageActivityController@getLighterVoyageDetaillsByID');
    Route::put('voyageActivityupdate', 'LighterVoyageActivityController@voyageActivityupdate');
    Route::get('getCreditorList', 'LighterVoyageActivityController@getCreditorList');
    Route::get('getMotherVesselList', 'LighterVoyageActivityController@getMotherVesselList');

    Route::get('getLighterVoyageMain','VoyageLighterMainController@getLighterVoyageMain');
    Route::put('lighterUpdate','VoyageLighterMainController@lighterUpdate');
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'voyageLighter'], function () {
    Route::prefix('lighterUnload')->group(function () {
        Route::get('getLighterUnload', 'LighterUnloadController@getLighterUnload');
    });
});


