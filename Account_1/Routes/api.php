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


Route::prefix('account')->group(function() {

    Route::post('/tree', 'TreeController@store')->name('tree.store');
    Route::post('/tree/destroy', 'TreeController@destroy')->name('tree.destroy');
    Route::post('/tree/update', 'TreeController@update')->name('tree.update');
});
