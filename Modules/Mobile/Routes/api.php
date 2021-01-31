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




Route::prefix('mobile')->group(function() {

    // auth routes
    Route::post('login', 'AuthController@login');
    
    Route::get('analysis', 'MobileController@getAnalysis');
    Route::get('contact-info', 'MobileController@getAppInfo');
    
});

Route::group(['middleware' => 'student_auth'], function () {
    Route::prefix('mobile')->group(function() {
        
        Route::get('notifications', 'MobileController@getNotifications');
        Route::get('services', 'MobileController@getStudentServices');
        Route::get('result', 'MobileController@getStudentResult');
        Route::get('accountting', 'MobileController@getStudentAccount');
        Route::get('academic', 'MobileController@getStudentAcademic');
        
    });
});

