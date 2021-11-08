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

// Route::middleware('auth:api')->get('/psd', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => 'auth:api', 'prefix' => 'psd'], function () {
Route::group(['prefix' => 'psd'], function () {
    Route::get('getConstruction', 'PSDController@getConstruction');
    Route::get('getActivity', 'PSDController@getActivity');
    Route::get('getFeedBack', 'PSDController@getFeedBack');
    Route::get('getComplaintProblemType', 'PSDController@getComplaintProblemType');
    Route::get('getComplaintSolvedType', 'PSDController@getComplaintSolvedType');
    Route::get('getComplaintForwardedType', 'PSDController@getComplaintForwardedType');
    Route::get('getProgramType', 'PSDController@getProgramType');
    Route::post('programTypeStore', 'PSDController@programTypeStore');
    Route::put('programTypeUpdate', 'PSDController@programTypeUpdate');
    Route::delete('programTypeDelete/{intProgramTypeId}', 'PSDController@programTypeDelete');

    Route::prefix('promotionProgram')->group(function () {
        Route::get('indexPromotionProgram', 'PromotionProgramController@indexPromotionProgram');
        Route::post('promotionProgramStore', 'PromotionProgramController@promotionProgramStore');
        Route::put('promotionProgramUpdate', 'PromotionProgramController@promotionProgramUpdate');
        Route::delete('promotionProgramDelete/{id}', 'PromotionProgramController@promotionProgramDelete');
    });

    Route::prefix('complaintHandling')->group(function () {
        Route::get('indexComplaintHandling', 'ComplaintHandlingController@indexComplaintHandling');
        Route::post('complaintHandlingStore', 'ComplaintHandlingController@complaintHandlingStore');
        Route::put('complaintHandlingUpdate', 'ComplaintHandlingController@complaintHandlingUpdate');
        Route::delete('complaintHandlingDelete/{id}', 'ComplaintHandlingController@complaintHandlingDelete');
    });

    Route::prefix('siteVisit')->group(function () {
        Route::get('indexSiteVisit', 'SiteVisitController@indexSiteVisit');
        Route::post('siteVisitStore', 'SiteVisitController@siteVisitStore');
        Route::put('siteVisitUpdate', 'SiteVisitController@siteVisitUpdate');
        Route::delete('siteVisitDelete/{id}', 'SiteVisitController@siteVisitDelete');
    });

    Route::prefix('engConsultant')->group(function () {
        Route::get('indexEngConsultant', 'EngConsultantController@indexEngConsultant');
        Route::post('engConsultantStore', 'EngConsultantController@engConsultantStore');
        Route::put('engConsultantUpdate', 'EngConsultantController@engConsultantUpdate');
        Route::delete('engConsultantDelete/{id}', 'EngConsultantController@engConsultantDelete');
    });
});
