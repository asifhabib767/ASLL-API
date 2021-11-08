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

Route::group(['middleware' => 'auth:api','prefix' =>'sms'], function () {
    // Mater Data

    Route::post('SmsSend', 'SmsController@SmsSend');
    Route::get('GetFGItemListForAFML', 'SmsController@GetFGItemListForAFML');
    Route::get('GetCustomerForAFML', 'SmsController@GetCustomerForAFML');
    Route::get('GetPendingItemByCustomerForAFML', 'SmsController@GetPendingItemByCustomerForAFML');

    Route::post('SmsSendByITDept', 'SmsController@SmsSendByITDept');

});
