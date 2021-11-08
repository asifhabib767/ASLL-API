<?php

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


Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('vehicle')->group(function () {
        // Master Data
        Route::post('createVehicleLog', 'VehicleLogController@createVehicleLog');
        Route::get('getVehicleLogList', 'VehicleLogController@getVehicleLogList');
        Route::get('getVehicleLogDetailsById', 'VehicleLogController@getVehicleLogDetailsById');
        Route::put('vehicleMeterApprove', 'VehicleLogController@vehicleMeterApprove');
    });

    Route::prefix('expense')->group(function () {
        Route::get('getExpenseType', 'ExpenseController@getExpenseType');
        Route::get('getExpenseCategoryType', 'ExpenseController@getExpenseCategoryType');
        Route::get('getReferenceType', 'ExpenseController@getReferenceType');
        Route::get('getTransactionType', 'ExpenseController@getTransactionType');
        Route::get('getExpense', 'ExpenseController@getExpense');
        Route::get('getExpenseById', 'ExpenseController@getExpenseById');
        Route::get('getReference', 'ExpenseController@getReference');
        Route::get('getTransaction', 'ExpenseController@getTransaction');
        Route::post('storeExpense', 'ExpenseController@storeExpense');
        Route::put('updateExpense', 'ExpenseController@updateExpense');
        Route::delete('deleteExpense', 'ExpenseController@deleteExpense');
        Route::get('getSupervisorAprvPending', 'ExpenseController@getSupervisorAprvPending');
    });
});
