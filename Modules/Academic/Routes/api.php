<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteCourseProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api_auth'], function () {
    Route::prefix('academic')->group(function() {
        // courses routes
        Route::get('courses', 'CourseController@get');
        Route::post('courses/store', 'CourseController@store');
        Route::post('courses/update/{resource}', 'CourseController@update');
        Route::post('courses/delete/{resource}', 'CourseController@destroy');
 

        // courses category routes
        Route::get('course_categories', 'CourseCategoryController@get');
        Route::post('course_categories/store', 'CourseCategoryController@store');
        Route::post('course_categories/update/{resource}', 'CourseCategoryController@update');
        Route::post('course_categories/delete/{resource}', 'CourseCategoryController@destroy');


        // DegreeMap routes
        Route::get('degree_maps', 'DegreeMapController@get');
        Route::post('degree_maps/store', 'DegreeMapController@store');
        Route::post('degree_maps/update/{resource}', 'DegreeMapController@update');
        Route::post('degree_maps/delete/{resource}', 'DegreeMapController@destroy');

        // doctor routes
        Route::get('doctors', 'DoctorController@get');
        Route::post('doctors/store', 'DoctorController@store');
        Route::post('doctors/update/{resource}', 'DoctorController@update');
        Route::post('doctors/delete/{resource}', 'DoctorController@destroy');
        

        // settings routes
        Route::get('settings', 'SettingController@get');
        Route::post('settings/update', 'SettingController@update');
        Route::post('settings/update-publish-result', 'SettingController@updatePublishResult');


        // settings routes
        Route::get('open_courses', 'OpenCourseController@get');
        Route::post('open_courses/update', 'OpenCourseController@update');
         
        // student register routes
        Route::get('available_courses', 'StudentRegisterController@getCourses');
        Route::post('register_courses/update', 'StudentRegisterController@registerCourses');
        
        //
        Route::get('get_student_academic', 'AcademicController@getStudentInfo');
        
        Route::get('result/get', 'StudentResultController@get');
        Route::post('result/update', 'StudentResultController@update');
        
        // reports
        Route::get('report/get-result', 'ReportController@getResult');
        
        // result transfer
        Route::get('result-transfer/get', 'ResultTranferController@get');
        Route::post('result-transfer/start', 'ResultTranferController@start');
        
    });
});

