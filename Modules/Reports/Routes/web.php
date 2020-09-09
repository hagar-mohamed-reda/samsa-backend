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

Route::prefix('report')->group(function() {
    Route::get('/setting', 'ReportsController@setting')->name('reportSetting');
    Route::post('/update/{setting}', 'ReportsController@update')->name('reportUpdateSetting');
    Route::get('/letter_sending_to_institute', 'ReportsController@letterSendingToInstitute')->name('letterSendingToInstituteReport');
    Route::get('/letter_sending_from_institute', 'ReportsController@letterSendingFromInstitute')->name('letterSendingFromInstituteReport');
});
