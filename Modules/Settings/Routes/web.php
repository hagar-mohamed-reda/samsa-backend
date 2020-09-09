<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth:web'], function(){
    Route::resource('settings', 'SettingsController');
    Route::resource('academic-years', 'AcademicYearController');
    Route::resource('qualifications', 'QualilificationController');
    Route::resource('qualification-types', 'QualilificationTypesController');
    Route::resource('users', 'UserController');
    Route::resource('parent-jobs', 'ParentJobsController');
    Route::resource('case-constraint', 'CaseConstraintController');
    Route::resource('constraint-status', 'ConstraintStatusController');
    Route::resource('registeration-status', 'RegisterationStatusController');
    Route::resource('registeration-methods', 'RegistrationMethodsController');
    Route::resource('student-code-series', 'StudentCodeSeriesController');
    Route::post('users-jobs/store', 'UserJobsController@store')->name('storeUser');
    
    Route::get('translation', 'TranslationController@index')->name('translationIndex');
    Route::post('translation/update', 'TranslationController@update')->name('translationUpdate');
    
    Route::post('registeration-status/update-required-document/{registerationStatus}', 'RegisterationStatusController@updateRequiredDocument')->name('registerationStatusUpdateRequiredData');
    
});
