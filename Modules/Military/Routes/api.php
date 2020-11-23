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
    
    // military area 
    Route::get('military_areas', 'MilitaryAreaController@index'); 
    Route::post('military_areas/store', 'MilitaryAreaController@store');
    Route::post('military_areas/update/{resource}', 'MilitaryAreaController@update');
    Route::post('military_areas/delete/{resource}', 'MilitaryAreaController@destroy');
 
    
    // military status 
    Route::get('military_status', 'MilitaryStatusController@index'); 
    Route::post('military_status/store', 'MilitaryStatusController@store');
    Route::post('military_status/update/{resource}', 'MilitaryStatusController@update');
    Route::post('military_status/delete/{resource}', 'MilitaryStatusController@destroy');
 

});
