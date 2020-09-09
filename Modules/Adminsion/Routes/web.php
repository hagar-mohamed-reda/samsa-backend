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
    Route::resource('adminsion', 'AdminsionController');
    Route::resource('applications', 'ApplicationController');
    Route::resource('application-requirments', 'ApplicationRequiredController');
    Route::resource('required_documents', 'RequiredDocumentController');
    //
    
    Route::post('applications/store', 'ApplicationController@store')->name('applicationStore');
});

