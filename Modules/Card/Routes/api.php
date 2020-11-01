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

    Route::prefix('card')->group(function() {

        // 
        Route::get('get_student_card_info', 'CardController@index'); 
        Route::post('export_card', 'CardController@exportCard');


        // servicecs routes
        Route::get('card_types', 'CardTypeController@index');
        Route::post('card_types/store', 'CardTypeController@store');
        Route::post('card_types/update/{resource}', 'CardTypeController@update'); 
 

        // servicecs routes
        Route::get('card_types/show/{resource}', 'CardTypeController@show');

        // report
        Route::get('report/card_export', 'CardReportController@index');


    });
});