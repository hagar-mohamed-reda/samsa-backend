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
    Route::resource('levels', 'LevelController');
    Route::resource('departments', 'DepartmentController');
    Route::get('department/{level_id}', 'DepartmentController@getDepartments');

    Route::resource('divisions', 'DivisionsController');
});

