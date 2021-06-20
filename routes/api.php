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



Route::middleware(['auth-application'])->group(function () {
    Route::post('disableAndEnableNotifications', 'ApplicationController@enableAndDisable');
    Route::get('detailApplication', 'ApplicationController@getDetailApplication');
    Route::get('sms', 'NotificationController@get');

    Route::middleware(['verify-application'])->group(function () {
        Route::post('sms', 'NotificationController@send');
    });
});

