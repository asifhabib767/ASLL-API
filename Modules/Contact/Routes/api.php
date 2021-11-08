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

Route::group(['middleware' => 'auth:api', 'prefix' =>'contact/contacts'], function () {
    Route::post('store', 'ContactController@store');
    Route::post('contactStoreImage', 'ContactController@contactStoreImage');
    Route::get('getContacts', 'ContactController@getContacts');
    Route::get('getContactGroup', 'ContactController@getContactGroup');
    Route::put('updateContact', 'ContactController@updateContact');
});
