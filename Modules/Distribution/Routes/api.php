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

// Route::middleware('auth:api')->get('/distribution', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'auth:api', 'prefix' => 'distribution'], function () {
    Route::get('getShipmentPlanningList', 'ShipmentPlanningController@getShipmentPlanningList');
    Route::put('editShipmentPlanning', 'ShipmentPlanningController@editShipmentPlanning');
    Route::post('addShipmentPlanning', 'ShipmentPlanningController@addShipmentPlanning');
    Route::get('getSupplierList', 'ShipmentPlanningController@getSupplierList');
});
