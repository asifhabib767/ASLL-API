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

Route::group(['middleware' => 'auth:api', 'prefix' => 'asllhr'], function () {
    // Master Data
    Route::post('createEmployeePersonal', 'ASLLHREmployeeController@createEmployeePersonal');
    Route::get('getEmployeePersonal', 'ASLLHREmployeeController@index');
    Route::get('getEmployeeDropdownList', 'ASLLHREmployeeController@getEmployeeDropdownList');
    Route::get('getEmployeePersonalDetails/{intID}', 'ASLLHREmployeeController@getEmployeePersonalDetails');
    Route::get('getEmployeeDetails/{intID}', 'ASLLHREmployeeController@getEmployeeDetails');
    Route::post('updateEmployeePersonal', 'ASLLHREmployeeController@updateEmployeePersonal');
    Route::delete('deleteEmployee/{id}', 'ASLLHREmployeeController@deleteEmployee');
    Route::get('getemployeeSearch', 'ASLLHREmployeeController@getemployeeSearch');
    Route::get('getRanks', 'RanksController@getRanks');
    Route::get('getCurrency', 'CurrencyController@getCurrency');
    Route::get('getRanksPrint', 'RanksController@getRanksPrint');

    Route::post('currencyConversionPost', 'CurrencyController@currencyConversionPost');

    Route::post('createEmployeeEducation', 'ASLLHREmployeeEducationController@createEmployeeEducation');
    Route::put('updateEmployeeEducation', 'ASLLHREmployeeEducationController@updateEmployeeEducation');

    // Promotion
    Route::post('promotion/addEmployeePromotion', 'ASLLHREmployeePromotionController@addEmployeePromotion');
    Route::get('promotion/getEmployeePromotionList', 'ASLLHREmployeePromotionController@getEmployeePromotionList');
    Route::delete('promotion/deleteEmployeePromotion', 'ASLLHREmployeePromotionController@deleteEmployeePromotion');
    Route::put('promotion/updateEmployeePromotion', 'ASLLHREmployeePromotionController@updateEmployeePromotion');

    Route::post('createEmployeeRecord', 'ASLLHREmployeeRecordController@createEmployeeRecord');
    Route::put('updateEmployeeRecord', 'ASLLHREmployeeRecordController@updateEmployeeRecord');


    Route::post('createEmployeeReference', 'ASLLHREmployeeReferenceController@createEmployeeReference');
    Route::post('updateEmployeeReference', 'ASLLHREmployeeReferenceController@updateEmployeeReference');


    Route::post('createEmployeeDocument', 'ASLLHREmployeeDocumentController@createEmployeeDocument');
    Route::put('updateEmployeeDocument', 'ASLLHREmployeeDocumentController@updateEmployeeDocument');

    Route::post('createEmployeeCertificate', 'ASLLHREmployeeCertificateController@createEmployeeCertificate');
    Route::put('updateEmployeeCertificate', 'ASLLHREmployeeCertificateController@updateEmployeeCertificate');
    Route::get('getEmployeeCertificateList', 'ASLLHREmployeeCertificateController@getEmployeeCertificateList');

    Route::post('createEmployeeBankDetails', 'ASLLHREmployeeBankDetailsController@createEmployeeBankDetails');
    Route::post('updateEmployeeBankDetails', 'ASLLHREmployeeBankDetailsController@updateEmployeeBankDetails');


    Route::post('createEmployeeReference', 'ASLLHREmployeeReferenceController@createEmployeeReference');
    Route::post('updateEmployeeReference', 'ASLLHREmployeeReferenceController@updateEmployeeReference');

    Route::get('getAdditionDeductionTypeList', 'ASLLHRAdditionDeductionTypeController@getAdditionDeductionTypeList');
    Route::get('additionDeductionListByEmployee', 'ASLLHRAdditionDeductionController@additionDeductionListByEmployee');
    Route::get('getTransactionType', 'ASLLHRAdditionDeductionController@getTransactionType');

    Route::get('getVesselAccountInfo/{intVesselId}', 'AsllVesselAccountController@getVesselAccountInfo');
    Route::get('getVesselAccountTransaction', 'AsllVesselAccountController@getVesselAccountTransaction');
    Route::put('updateVesselAccountInfo', 'AsllVesselAccountController@updateVesselAccountInfo');

    Route::post('createAdditionDeduction', 'ASLLHRAdditionDeductionController@createAdditionDeduction');
    Route::delete('deleteAdditionDetailsData', 'ASLLHRAdditionDeductionController@deleteAdditionDetailsData');
    Route::put('updateAdditionDetailsData', 'ASLLHRAdditionDeductionController@updateAdditionDetailsData');


    Route::get('getHrAttendanceList', 'ASLLHRAttendanceController@getHrAttendanceList');
    Route::get('getSuperviserAbesenceEmployee', 'ASLLHRAttendanceController@getSuperviserAbesenceEmployee');
    //addition deduction requisition upload file
    Route::post('fileInput', 'AdditionDeductionFileUploadController@fileInput');

    //EmployeeSignIn/Out
    Route::prefix('employeeSignInOut')->group(function () {
        Route::get('', 'ASLLHREmployeeSignInOutController@getEmployeeSignInOut');
        Route::post('create', 'ASLLHREmployeeSignInOutController@create');
        Route::put('update', 'ASLLHREmployeeSignInOutController@update');
        Route::delete('deleteEmployeeSignInOut', 'ASLLHREmployeeSignInOutController@deleteEmployeeSignInOut');
        Route::get('getemployeeSigningSearch', 'ASLLHREmployeeSignInOutController@getemployeeSigningSearch');
    });

    Route::prefix('crReport')->group(function () {
        Route::get('', 'ASLLHREmployeeSignInOutController@getEmployeeSignInOut');
        Route::post('create', 'ASLLHREmployeeSignInOutController@create');
        Route::put('update', 'ASLLHREmployeeSignInOutController@update');
        Route::delete('deleteEmployeeSignInOut', 'ASLLHREmployeeSignInOutController@deleteEmployeeSignInOut');
        Route::get('getemployeeSigningSearch', 'ASLLHREmployeeSignInOutController@getemployeeSigningSearch');
        Route::get('getCrReportCriteriaOption', 'AsllCrReportController@getCrReportCriteriaOption');
        Route::get('getCrReportEmployeeInfoByEmployeeId', 'AsllCrReportController@getCrReportEmployeeInfoByEmployeeId');
        Route::post('store', 'AsllCrReportController@store');
        Route::get('getCrReportList', 'AsllCrReportController@getCrReportList');
        Route::get('getCrReportCriteriaOptionById', 'AsllCrReportController@getCrReportCriteriaOptionById');
        Route::get('getCrReportDetails', 'AsllCrReportController@getCrReportDetails');
    });

    // //Currency
    // Route::prefix('currency')->group(function () {
    //     Route::get('', 'CurrencyController@getCurrency');
    //     Route::post('create', 'CurrencyController@create');
    //     Route::put('update', 'CurrencyController@update');
    //     Route::delete('delete', 'CurrencyController@delete');
    // });
    Route::resource('vesselItem', AsllHrVesselItemController::class);

    //EmployeeApplication
    Route::group(['middleware' => 'auth:api', 'prefix' => 'employeeApplication'], function () {
        Route::get('', 'ASLLHREmployeeApplicationController@getEmployeeApplication');
        Route::post('create', 'ASLLHREmployeeApplicationController@create');
        Route::put('update', 'ASLLHREmployeeApplicationController@update');
        Route::delete('deleteEmployeeApplication', 'ASLLHREmployeeApplicationController@deleteEmployeeApplication');
        Route::get('getEmployeeApplicationSearch', 'ASLLHREmployeeApplicationController@getEmployeeApplicationSearch');
        Route::get('getById', 'ASLLHREmployeeApplicationController@getById');
    });

    //EmployeeApplicationType
    Route::group(['middleware' => 'auth:api', 'prefix' => 'employeeApplicationType'], function () {
        Route::get('', 'ASLLHREmployeeApplicationTypeController@getEmployeeApplicationType');
        Route::post('create', 'ASLLHREmployeeApplicationTypeController@create');
        Route::put('update', 'ASLLHREmployeeApplicationTypeController@update');
        Route::delete('deleteEmployeeApplicationType', 'ASLLHREmployeeApplicationTypeController@deleteEmployeeApplicationType');
        Route::get('getEmployeeApplicationTypeSearch', 'ASLLHREmployeeApplicationTypeController@getEmployeeApplicationTypeSearch');
    });
});
