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

Route::middleware('auth:api')->get('/settings', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api_auth'], function () {

//academic years start
    Route::get('academic-years', 'AcademicYearController@index');
    Route::get('academic-years/{id}', 'AcademicYearController@show');
    Route::post('academic-years', 'AcademicYearController@store');
    Route::delete('academic-years/{id}', 'AcademicYearController@destroy');
    Route::put('academic-years/{id}', 'AcademicYearController@update');

//Route::resource('academic-years', 'AcademicYearController');
//academic years end

//qualifications start
    Route::get('qualifications', 'QualilificationController@index');
    Route::get('qualifications/{id}', 'QualilificationController@show');
    Route::post('qualifications', 'QualilificationController@store');
    Route::delete('qualifications/{id}', 'QualilificationController@destroy');
    Route::put('qualifications/{id}', 'QualilificationController@update');
//    Route::resource('qualifications', 'QualilificationController');
//qualifications end

});
