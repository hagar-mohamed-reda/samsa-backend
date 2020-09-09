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

Route::group(['middleware' => 'auth:web'], function() {
    Route::resource('military-status', 'MilitaryStatusController');
    Route::resource('military-areas', 'MilitaryAreasController');
    Route::resource('military-area-submission', 'MilitaryAreaSubmisionController');
    Route::resource('military-status-reason', 'MilitaryStatusSettingController');
    Route::get('military/setting', 'MilitarySettingController@index');
    Route::resource('military-course', 'MilitaryCourseController');
    Route::resource('military-course-collection', 'MilitaryCourseCollectionController');
    Route::resource('military-course-students', 'StudentMilitaryCourseController');
    Route::get('military-course-student/{id}', 'StudentMilitaryCourseController@getStudents')->name('militaryStudentCourse');
    Route::get('military-course-student-collection/{id}', 'StudentMilitaryCourseController@getCollectionStudents')->name('getCollectionStudents');
    Route::get('military-course-student-report/{id}', 'StudentMilitaryCourseController@getStudentsReport')->name('getStudentsReport');
    Route::post('military-course-student-collection', 'StudentMilitaryCourseController@postCollectionStudents')->name('postCollectionStudents');
   Route::get('delete-military-cource-student/{student_id}',  'StudentMilitaryCourseController@delteteCollectionStudent')->name('dede');
});
    