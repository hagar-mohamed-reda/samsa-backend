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

Route::middleware('auth:api')->get('/military', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api_auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    //start military-areas
    Route::get('military-areas', 'MilitaryAreasController@index')->name('nationalities');
    Route::get('military-areas/{id}', 'MilitaryAreasController@show');
    Route::post('military-areas', 'MilitaryAreasController@store');
    Route::delete('military-areas/{id}', 'MilitaryAreasController@destroy');
    Route::put('military-areas/{id}', 'MilitaryAreasController@update');
    //end military-areas

});
