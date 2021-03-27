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

    //countries start
    Route::get('countries', 'CountryController@index');
    Route::post('countries/store', 'CountryController@store');
    Route::post('countries/update/{resource}', 'CountryController@update');
    Route::post('countries/delete/{resource}', 'CountryController@destroy');

    //governments start
    Route::get('governments', 'GovernmentController@index');
    Route::post('governments/store', 'GovernmentController@store');
    Route::post('governments/update/{resource}', 'GovernmentController@update');
    Route::post('governments/delete/{resource}', 'GovernmentController@destroy');

    //cities start
    Route::get('cities', 'CityController@index');
    Route::post('cities/store', 'CityController@store');
    Route::post('cities/update/{resource}', 'CityController@update');
    Route::post('cities/delete/{resource}', 'CityController@destroy');

    //academic_years start
    Route::get('academic_years', 'AcademicYearController@index');
    Route::post('academic_years/store', 'AcademicYearController@store');
    Route::post('academic_years/update/{resource}', 'AcademicYearController@update');
    Route::post('academic_years/delete/{resource}', 'AcademicYearController@destroy');

    //levels
    Route::get('levels', 'LevelController@index');
    Route::post('levels/store', 'LevelController@store');
    Route::post('levels/update/{resource}', 'LevelController@update');
    Route::post('levels/delete/{resource}', 'LevelController@destroy');

    //divisions
    Route::get('divisions', 'DivisionController@index');
    Route::post('divisions/store', 'DivisionController@store');
    Route::post('divisions/update/{resource}', 'DivisionController@update');
    Route::post('divisions/delete/{resource}', 'DivisionController@destroy');

    //departments
    Route::get('departments', 'DepartmentController@index');
    Route::post('departments/store', 'DepartmentController@store');
    Route::post('departments/update/{resource}', 'DepartmentController@update');
    Route::post('departments/delete/{resource}', 'DepartmentController@destroy');

    //qualifications
    Route::get('qualifications', 'QualificationController@index');
    Route::post('qualifications/store', 'QualificationController@store');
    Route::post('qualifications/update/{resource}', 'QualificationController@update');
    Route::post('qualifications/delete/{resource}', 'QualificationController@destroy');

    //qualification_types
    Route::get('qualification_types', 'QualificationTypeController@index');
    Route::post('qualification_types/store', 'QualificationTypeController@store');
    Route::post('qualification_types/update/{resource}', 'QualificationTypeController@update');
    Route::post('qualification_types/delete/{resource}', 'QualificationTypeController@destroy');

    //registration_methods
    Route::get('registration_methods', 'RegistrationMethodController@index');
    Route::post('registration_methods/store', 'RegistrationMethodController@store');
    Route::post('registration_methods/update/{resource}', 'RegistrationMethodController@update');
    Route::post('registration_methods/delete/{resource}', 'RegistrationMethodController@destroy');

    //required_documents
    Route::get('required_documents', 'RequiredDocumentController@index');
    Route::post('required_documents/store', 'RequiredDocumentController@store');
    Route::post('required_documents/update/{resource}', 'RequiredDocumentController@update');
    Route::post('required_documents/delete/{resource}', 'RequiredDocumentController@destroy');


    //case_contraint
    Route::get('case_contraints', 'CaseConstraintController@index');
    Route::post('case_contraints/store', 'CaseConstraintController@store');
    Route::post('case_contraints/update/{resource}', 'CaseConstraintController@update');
    Route::post('case_contraints/delete/{resource}', 'CaseConstraintController@destroy');


    //nationalities
    Route::get('nationalities', 'NationalityController@index');
    Route::post('nationalities/store', 'NationalityController@store');
    Route::post('nationalities/update/{resource}', 'NationalityController@update');
    Route::post('nationalities/delete/{resource}', 'NationalityController@destroy');


    //languages
    Route::get('languages', 'LanguageController@index');
    Route::post('languages/store', 'LanguageController@store');
    Route::post('languages/update/{resource}', 'LanguageController@update');
    Route::post('languages/delete/{resource}', 'LanguageController@destroy');


    //parent_jobs
    Route::get('parent_jobs', 'ParentJobController@index');
    Route::post('parent_jobs/store', 'ParentJobController@store');
    Route::post('parent_jobs/update/{resource}', 'ParentJobController@update');
    Route::post('parent_jobs/delete/{resource}', 'ParentJobController@destroy');


    //student_code_series
    Route::get('student_code_series', 'StudentCodeSeriesController@index');
    Route::post('student_code_series/store', 'StudentCodeSeriesController@store');
    Route::post('student_code_series/update/{resource}', 'StudentCodeSeriesController@update');
    Route::post('student_code_series/delete/{resource}', 'StudentCodeSeriesController@destroy');


    //relations
    Route::get('relations', 'RelationController@index');
    Route::post('relations/store', 'RelationController@store');
    Route::post('relations/update/{resource}', 'RelationController@update');
    Route::post('relations/delete/{resource}', 'RelationController@destroy');


    //
    Route::get('registration-status', 'RegisterationStatusController@index');
    Route::post('registration-status', 'RegisterationStatusController@store');
    Route::put('registration-status/{id}', 'RegisterationStatusController@update');
    Route::delete('registration-status/{resource}', 'RegisterationStatusController@destroy');
    Route::post('registration-status/document/{resource}', 'RegisterationStatusController@updateRequiredDocument');

    //
    // translation
    Route::post('translation/update', 'TranslationController@update');


    // permissions
    Route::get('permissions', 'PermissionController@index');
    Route::post('permissions/store', 'PermissionController@store');
    Route::post('permissions/update/{resource}', 'PermissionController@update');
    Route::post('permissions/delete/{resource}', 'PermissionController@destroy');

    // permissions_groups
    Route::get('permission_groups', 'PermissionGroupController@index');
    Route::post('permission_groups/store', 'PermissionGroupController@store');
    Route::post('permission_groups/update/{resource}', 'PermissionGroupController@update');
    Route::post('permission_groups/delete/{resource}', 'PermissionGroupController@destroy');
});



    // translation
    Route::get('translation', 'TranslationController@index');
    Route::get('translation/get', 'TranslationController@get');
