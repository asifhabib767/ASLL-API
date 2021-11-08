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

// Route::middleware('auth:api')->get('/hr', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api','prefix' =>'hr'], function () {

        // Mater Data
        Route::get('getSalaryStatement', 'HRController@getSalaryStatement');
        Route::get('getCafeteriaMenuList', 'HRController@getCafeteriaMenuList');
        Route::get('getMealList', 'HRController@getMealList');
        Route::put('deleteMealList', 'HRController@deleteMealList');
        Route::get('getUserDataByUserEmail', 'HRLoginController@getUserDataByUserEmail');
        Route::get('gettAttenanceDailySummaryReport', 'HRController@gettAttenanceDailySummaryReport');
        Route::get('getLeaveApplicationSummaryByUser', 'HRController@getLeaveApplicationSummaryByUser');
        Route::get('getLeaveApplicationTypeByUser', 'HRController@getLeaveApplicationTypeByUser');
        Route::delete('DeleteLeaveApplication', 'HRController@DeleteLeaveApplication');
        Route::get('getMovementApplicationSummaryByUser', 'HRController@getMovementApplicationSummaryByUser');
        Route::post('postLeaveApplication', 'HRController@postLeaveApplication');
        Route::get('GetMovementType', 'HRController@GetMovementType');
        Route::get('GetCountryList', 'HRController@GetCountryList');
        Route::post('MovementApplication', 'HRController@MovementApplication');
        Route::get('GetDistrictList', 'HRController@GetDistrictList');
        Route::delete('MovementApplicationDelete', 'HRController@MovementApplicationDelete');
        // Entry, Update Purchase Requisition

        // Checkpoint
        Route::post('createCheckpoint', 'CheckpointsController@createCheckpoint');
        Route::get('checkpoints', 'CheckpointsController@checkpoints');
        Route::get('qrcodes', 'CheckpointsController@qrcodes');
        Route::put('updateQrCode', 'CheckpointsController@updateQrCode');
        Route::get('getProfileByEnrollandUnitId', 'HRController@getProfileByEnrollandUnitId');
        Route::get('getEmployeeProfileSearch', 'HRController@getEmployeeProfileSearch');
        Route::get('getEmployeeProfileDetails', 'HRController@getEmployeeProfileDetails');
        Route::get('getGeolocationforAllJobstation', 'HRController@getGeolocationforAllJobstation');
        Route::get('getGeolocationforSingleJobstation', 'HRController@getGeolocationforSingleJobstation');
        Route::post('postGeolocationUpdateByManpower', 'HRController@postGeolocationUpdateByManpower');
        Route::post('postEmployeeAttendance', 'HRController@postEmployeeAttendance');
        Route::put('updateEmployeeDesignation', 'HRController@updateEmployeeDesignation');
        Route::get('getSupervisorVsEmployeeList', 'HRController@getSupervisorVsEmployeeList');
        Route::post('postOvertimeEntry', 'HRController@postOvertimeEntry');


        // Task Management
        Route::get('getTaskAssignedToEmployee', 'TasksController@getTaskAssignedToEmployee');
        Route::get('getTaskAssignedByEmployee', 'TasksController@getTaskAssignedByEmployee');
        Route::post('storeNewTask', 'TasksController@storeNewTask');
        Route::put('updateTask', 'TasksController@updateTask');
        Route::post('storeEmployeeTrack', 'TasksController@storeEmployeeTrack');
        Route::get('getEmployeeDutyInfo', 'TasksController@getEmployeeDutyInfo');
        Route::get('getEmployeePuchInfo', 'TasksController@getEmployeePuchInfo');

        Route::post('creatEmployee','TasksController@storeEmployee');
});


Route::get('getEmployeeProfileDetailsWithoutAuth', 'HRLoginController@getEmployeeProfileDetailsWithoutAuth');


