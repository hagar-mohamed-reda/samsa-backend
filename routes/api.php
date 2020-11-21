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
 

Route::get('/api_auth', function (Illuminate\Http\Request $request) {
    return responseJson(0, __('login first'));
});


Route::post('/auth/login', 'AuthController@login')->name('dashboard');


Route::group(['middleware' => 'api_auth'], function () {
   
 
    //end
    Route::get('roles', 'RoleController@index');

    Route::resource('roles', 'RoleController');

    Route::get('government/{country_id}', 'GovernmentController@getGovernments');
    Route::resource('profile', 'UserProfileController');
    Route::put('update-password/{user_id}', 'UserProfileController@updatePassword')->name('update-password');
    Route::post('setting/update/{setting}', 'SettingController@update')->name('SettingUpdate');


    // auth
    Route::get('profile', 'AuthController@getProfile'); 
    Route::post("profile/update", "AuthController@update");
    Route::post("profile/update-password", "AuthController@updatePassword");
    Route::post("profile/update-phone", "AuthController@updatePhone");

    //

    Route::get("system-setting", "DashboardController@getSettings");
    Route::get("notifications", "DashboardController@getNotifications");
});
