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


Route::group(['middleware' => 'auth:api', 'prefix' => 'asll'], function () {
    Route::get('getCountries', 'AsllController@getCountries');
    Route::get('getShipConditionType', 'AsllController@getShipConditionType');
    Route::get('getShipEngine', 'AsllController@getShipEngine');
    Route::get('getShipPosition', 'AsllController@getShipPosition');

    Route::prefix('vessel')->group(function () {
        // Vessels
        Route::get('', 'VesselsController@index');
        Route::post('store', 'VesselsController@store');
        Route::get('getFtpImage', 'VesselsController@getFtpImage');
        Route::put('update', 'VesselsController@update');
        Route::get('show/{id}', 'VesselsController@show');
        Route::delete('delete/{id}', 'VesselsController@destroy');
        Route::get('show/{id}', 'VesselsController@show');

        // Vessel Types
        Route::get('types', 'VesselTypesController@getVesselTypes');
    });


    Route::prefix('voyage')->group(function () {
        Route::get('', 'VoyagesController@index');
        Route::get('getVoyageByLastVesselId', 'VoyagesController@getVoyageByLastVesselId');
        Route::get('cargo', 'CargoController@index');
        Route::post('store', 'VoyagesController@store');
        Route::put('update', 'VoyagesController@update');
        Route::get('show/{id}', 'VoyagesController@show');
        Route::delete('delete/{id}', 'VoyagesController@destroy');


        // Ports
        Route::get('ports', 'VoyagePortsController@getVoyagePortList');
        Route::get('ports-search', 'VoyagePortsController@getVoyagePortListBySearch');
        Route::post('ports/store', 'VoyagePortsController@store');
    });

    Route::prefix('voyageActivity')->group(function () {
        Route::get('', 'VoyageActivityController@index');
        Route::post('store', 'VoyageActivityController@store');
        Route::get('show/{id}', 'VoyageActivityController@show');
        Route::get('showByDate', 'VoyageActivityController@showByDate');
        Route::get('voyageActivitySeaDistenceCalculation', 'VoyageActivityController@voyageActivitySeaDistenceCalculation');


        Route::get('vlsfo', 'VoyageActivityVlsfController@vlsfoIndex');
        Route::post('vlsfoStore', 'VoyageActivityVlsfController@storeVlsfo');
        Route::put('vlsfoUpdate', 'VoyageActivityVlsfController@vlsfoUpdate');


        Route::get('engine', 'VoyageActivityEngineController@indexEngine');
        Route::post('engineStore', 'VoyageActivityEngineController@engineStore');
        Route::post('engineUpdate', 'VoyageActivityEngineController@engineUpdate');

        Route::get('exhtIndex', 'VoyageActivityExhtEngineController@exhtIndex');
        Route::post('exhtStore', 'VoyageActivityExhtEngineController@storeExht');
        Route::put('exhtUpdate', 'VoyageActivityExhtEngineController@updateExht');

        Route::get('indexBoiler', 'VoyageActivityBoilerController@indexBoiler');
        Route::post('boilerStore', 'VoyageActivityBoilerController@boilerStore');
        Route::post('boilerUpdate', 'VoyageActivityBoilerController@boilerUpdate');

        Route::get('indexGasNChemical', 'GasNChemicalController@indexGasNChemical');
        Route::post('gasNChemicalStore', 'GasNChemicalController@gasNChemicalStore');

        Route::get('indexVoyageGasNChemical', 'VoyageGasNChemicalController@indexVoyageGasNChemical');
        Route::post('voyageGasNChemicalStore', 'VoyageGasNChemicalController@voyageGasNChemicalStore');
        Route::get('getWindDirection', 'VoyageActivityController@getWindDirection');
    });


    Route::get('vessel-servers', 'VesselServerController@getVesselServers');
});
