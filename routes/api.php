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

Route::get('/api_auth', function (Illuminate\Http\Request $request) {
    return responseJson(0, __('login first'));
});


Route::group(['middleware' => 'api_auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    //start nationalities
    Route::get('nationalities', 'nationalityController@index')->name('nationalities');
    Route::get('nationalities/{id}', 'nationalityController@show');
    Route::post('nationalities', 'nationalityController@store');
    Route::delete('nationalities/{id}', 'nationalityController@destroy');
    Route::put('nationalities/{id}', 'nationalityController@update');
    //end nationalities

    //start cities
    Route::get('cities', 'CityController@index');
    Route::get('cities/{id}', 'CityController@show');
    Route::post('cities', 'CityController@store');
    Route::delete('cities/{id}', 'CityController@destroy');
    Route::put('cities/{id}', 'CityController@update');

    //Route::resource('cities', 'CityController');
    //end cities

    //countries start
    Route::get('countries', 'CountryController@index');
    Route::get('countries/{id}', 'CountryController@show');
    Route::post('countries', 'CountryController@store');
    Route::delete('countries/{id}', 'CountryController@destroy');
    Route::put('countries/{id}', 'CountryController@update');

    
    //Route::resource('countries', 'CountryController');
    //end

    //governments start
    Route::get('governments', 'GovernmentController@index');
    Route::get('governments/{id}', 'GovernmentController@show');
    Route::post('governments', 'GovernmentController@store');
    Route::delete('governments/{id}', 'GovernmentController@destroy');
    Route::put('governments/{id}', 'GovernmentController@update');
    Route::get('government/{country_id}', 'GovernmentController@getGovernments');
    Route::get('country/{government_id}', 'GovernmentController@getCountry');


    //Route::resource('governments', 'GovernmentController');
    //end
    //language start
    Route::get('languages', 'LanguageController@index');
    Route::get('languages/{id}', 'LanguageController@show');
    Route::post('languages', 'LanguageController@store');
    Route::delete('languages/{id}', 'LanguageController@destroy');
    Route::put('languages/{id}', 'LanguageController@update');
    //Route::resource('languages', 'LanguageController');
    //end

    //relations start
    Route::get('relations', 'RelativeRelationController@index');
    Route::get('relations/{id}', 'RelativeRelationController@show');
    Route::post('relations', 'RelativeRelationController@store');
    Route::delete('relations/{id}', 'RelativeRelationController@destroy');
    Route::put('relations/{id}', 'RelativeRelationController@update');
    //Route::resource('relations', 'RelativeRelationController');

    //end
    Route::get('roles', 'RoleController@index');

    Route::resource('roles', 'RoleController');

    Route::get('government/{country_id}', 'GovernmentController@getGovernments');
    Route::resource('profile', 'UserProfileController');
    Route::put('update-password/{user_id}', 'UserProfileController@updatePassword')->name('update-password');
    Route::post('setting/update/{setting}', 'SettingController@update')->name('SettingUpdate');

});
