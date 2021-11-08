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

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('logistic')->group(function () {
        Route::prefix('driver')->group(function () {
            // Drivers
            Route::get('', 'DriverController@index');
            Route::get('show/{id}', 'DriverController@show');
            Route::put('update', 'DriverController@update');
        });

        Route::prefix('vehicle')->group(function () {
            // Drivers
            Route::get('', 'VehicleController@getVehicleList');
            Route::get('show/{id}', 'VehicleController@show');
            Route::put('update', 'VehicleController@vehicleUpdate');
            Route::get('getuservehicel', 'VehicleController@getUservsVehicleInfo');
            Route::get('getVehicleCapacity', 'VehicleController@getVehicleCapacity');
        });
    });


    Route::prefix('plc')->group(function () {
        Route::get('getPackerList', 'PlcController@getPackerList');
        Route::get('getPackerInformation', 'PlcController@getPackerInformation');
        Route::get('storePackerInformation', 'PlcController@storePackerInformation');
    });

    Route::prefix('accl-vehicle')->group(function () {
        Route::get('rotation-measure', 'UHFDataController@rotationMeasure');
        Route::post('uhf-reader', 'UHFDataController@storeUHFData');
    });
});
