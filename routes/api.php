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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api_auth', function(Illuminate\Http\Request $request) { 
    return responseJson(0, __('login first'));
});


Route::group(['middleware' => 'api_auth'], function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    //start nationalities
    Route::get('nationalities', 'nationalityController@index')->name('nationalities');
    Route::get('nationalities/{id}', 'nationalityController@show');
    Route::post('nationalities', 'nationalityController@store');
    Route::delete('nationalities/{id}', 'nationalityController@destroy');
    Route::put('nationalities/{id}', 'nationalityController@update');

    //end nationalities
    Route::resource('roles', 'RoleController');

    Route::resource('cities', 'CityController');
    Route::resource('countries', 'CountryController');
    Route::resource('governments', 'GovernmentController');
    Route::get('government/{country_id}', 'GovernmentController@getGovernments');
    Route::resource('languages', 'LanguageController');
    Route::resource('profile', 'UserProfileController');
    Route::put('update-password/{user_id}', 'UserProfileController@updatePassword')->name('update-password');
    Route::resource('relations', 'RelativeRelationController');


    Route::post('setting/update/{setting}', 'SettingController@update')->name('SettingUpdate');

});
