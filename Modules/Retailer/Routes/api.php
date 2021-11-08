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

Route::group(['middleware' => 'auth:api', 'prefix' => 'retailer'], function () {
    Route::get('getRetailerByUnitId', 'RetailerController@getRetailerByUnitId');
    Route::get('getRetailerByCustomer', 'RetailerController@getRetailerByCustomer');
    Route::post('storeRetailer', 'RetailerController@storeRetailer');
    Route::put('updateRetailer', 'RetailerController@updateRetailer');
    Route::delete('deleteRetailer/{id}', 'RetailerController@deleteRetailer');
});
