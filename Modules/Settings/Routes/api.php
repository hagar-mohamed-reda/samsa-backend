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

//qualifications start
    Route::get('qualification-types', 'QualilificationTypesController@index');
    Route::get('qualification-types/{id}', 'QualilificationTypesController@show');
    Route::post('qualification-types', 'QualilificationTypesController@store');
    Route::delete('qualification-types/{id}', 'QualilificationTypesController@destroy');
    Route::put('qualification-types/{id}', 'QualilificationTypesController@update');
//    Route::resource('qualification-types', 'QualilificationTypesController');
//qualifications end

//parent-jobs start
    Route::get('parent-jobs', 'ParentJobsController@index');
    Route::get('parent-jobs/{id}', 'ParentJobsController@show');
    Route::post('parent-jobs', 'ParentJobsController@store');
    Route::delete('parent-jobs/{id}', 'ParentJobsController@destroy');
    Route::put('parent-jobs/{id}', 'ParentJobsController@update');
//    Route::resource('parent-jobs', 'ParentJobsController');
//parent-jobs end

//case-constraint start
    Route::get('case-constraint', 'CaseConstraintController@index');
    Route::get('case-constraint/{id}', 'CaseConstraintController@show');
    Route::post('case-constraint', 'CaseConstraintController@store');
    Route::delete('case-constraint/{id}', 'CaseConstraintController@destroy');
    Route::put('case-constraint/{id}', 'CaseConstraintController@update');
//    Route::resource('case-constraint', 'CaseConstraintController');
//case-constraint end

//case-constraint start
Route::get('constraint-status', 'ConstraintStatusController@index');
Route::get('constraint-status/{id}', 'ConstraintStatusController@show');
Route::post('constraint-status', 'ConstraintStatusController@store');
Route::delete('constraint-status/{id}', 'ConstraintStatusController@destroy');
Route::put('constraint-status/{id}', 'ConstraintStatusController@update');
//    Route::resource('case-constraint', 'CaseConstraintController');
//case-constraint end

    Route::resource('registration-methods', 'RegistrationMethodsController');

    //
    Route::get('registration-methods', 'RegistrationMethodsController@index');
    Route::get('registration-methods/{id}', 'RegistrationMethodsController@show');
    Route::post('registration-methods', 'RegistrationMethodsController@store');
    Route::delete('registration-methods/{id}', 'RegistrationMethodsController@destroy');
    Route::put('registration-methods/{id}', 'RegistrationMethodsController@update');
    //
    // translation
    Route::get('translation', 'TranslationController@index');
    Route::post('translation/update', 'TranslationController@update');
});
