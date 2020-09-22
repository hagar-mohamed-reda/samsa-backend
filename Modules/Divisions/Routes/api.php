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

Route::middleware('auth:api')->get('/divisions', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'api_auth'], function () {
    Route::get('levels', 'LevelController@index');
    Route::get('levels/{id}', 'LevelController@show');
    Route::post('levels', 'LevelController@store');
    Route::delete('levels/{id}', 'LevelController@destroy');
    Route::put('levels/{id}', 'LevelController@update');


    Route::get('divisions', 'DivisionsController@index');
    Route::get('divisions/{id}', 'DivisionsController@show');
    Route::post('divisions', 'DivisionsController@store');
    Route::delete('divisions/{id}', 'DivisionsController@destroy');
    Route::put('divisions/{id}', 'DivisionsController@update');

    Route::get('departments', 'DepartmentController@index');
    Route::get('departments/{id}', 'DepartmentController@show');
    Route::post('departments', 'DepartmentController@store');
    Route::delete('departments/{id}', 'DepartmentController@destroy');
    Route::put('departments/{id}', 'DepartmentController@update');
    Route::get('department/{level_id}', 'DepartmentController@getDepartments');

});