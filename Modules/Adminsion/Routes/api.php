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
 
        
Route::group(['middleware' => 'api_auth'], function () {
    Route::prefix('adminision')->group(function() { 
        // servicecs routes
        Route::get('required_documents', 'RequiredDocumentController@index');
        Route::post('required_documents/store', 'RequiredDocumentController@store');
        Route::post('required_documents/update/{id}', 'RequiredDocumentController@update');
        Route::post('required_documents/delete/{id}', 'RequiredDocumentController@destroy'); 

        // ApplicationRequired  routes
        Route::get('application_requireds', 'ApplicationRequiredController@index');
        Route::post('application_requireds/update', 'ApplicationRequiredController@update'); 

        // servicecs routes
        Route::get('applications', 'ApplicationController@index');
        Route::get('applications/{id}', 'ApplicationController@get');
        Route::post('applications/store', 'ApplicationController@store');
        Route::post('applications/update/{resourcc}', 'ApplicationController@update');
        Route::post('applications/delete/{resourcc}', 'ApplicationController@destroy'); 


        // settings
        Route::get('get_departments', function(){
            return DB::table('departments')->get();
        });
        Route::get('get_case_constraints', function(){
        	return DB::table('case_constraints')->get();
        });
        Route::get('get_nationality', function(){
        	return DB::table('nationalities')->get();
        });
        Route::get('get_academic_years', function(){
        	return DB::table('academic_years')->get();
        });
        Route::get('get_qualification_types', function(){
        	return DB::table('qualification_types')->get();
        });
        Route::get('get_qualifications', function(){
        	return DB::table('qualifications')->get();
        });
        Route::get('get_registeration_status', function(){
        	return DB::table('registeration_status')->get();
        });
        Route::get('get_registration_methods', function(){
        	return DB::table('registration_methods')->get();
        });
        Route::get('get_languages', function(){
        	return DB::table('languages')->get();
        });
        Route::get('get_cities', function(){
        	return DB::table('cities')->get();
        });
        Route::get('get_governments', function(){
        	return DB::table('governments')->get();
        });
        Route::get('get_countries', function(){
        	return DB::table('countries')->get();
        });
        Route::get('get_military_status', function(){
        	return DB::table('military_status')->get();
        });

        Route::get('get_military_areas', function(){
        	return DB::table('military_areas')->get();
        });
        Route::get('get_parent_jobs', function(){
        	return DB::table('parent_jobs')->get();
        });
        Route::get('get_relative_relations', function(){
        	return DB::table('relative_relation')->get();
        });
        /*Route::get('get_student_requird_documents', function(){
        	return DB::table('nationalities')->get();
        });
        Route::get('get_nationality', function(){
        	return DB::table('nationalities')->get();
        });
        Route::get('get_nationality', function(){
        	return DB::table('nationalities')->get();
        });*/
    });
});
