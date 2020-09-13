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


//Route::prefix('account')->group(function() {
//
//    Route::post('/tree', 'TreeController@store')->name('tree.store');
//    Route::post('/tree/destroy', 'TreeController@destroy')->name('tree.destroy');
//    Route::post('/tree/update', 'TreeController@update')->name('tree.update');
//});

        
Route::group(['middleware' => 'api_auth'], function () {
    Route::prefix('account')->group(function() { 
        // servicecs routes
        Route::get('services', 'ServiceController@index');
        Route::post('services/store', 'ServiceController@store');
        Route::post('services/update/{service}', 'ServiceController@update');
        Route::post('services/delete/{service}', 'ServiceController@destroy');
        
        
        // academic_year_expense routes
        Route::get('academic_year_expenses', 'AcademicYearExpenseController@index');
        Route::post('academic_year_expenses/store', 'AcademicYearExpenseController@store');
        Route::post('academic_year_expenses/update/{resource}', 'AcademicYearExpenseController@update');
        Route::post('academic_year_expenses/delete/{resource}', 'AcademicYearExpenseController@destroy');
        
        // account routes
        Route::get('get_student_account', 'AccountController@getStudentAccounting');
        
        // installment routes
        Route::get('installment/get', 'InstallmentController@index');
        Route::post('installment/update', 'InstallmentController@update');
    });
});




Route::get('/account/students', function() {
    $students = Modules\Student\Entities\Student::get();
    return responseJson(1, "done", $students);
});

Route::get('/account/test', function() {
    $student = Modules\Account\Entities\Student::find(2);
    $value = $student->getStudentBalance()->getPaidValue();
    dump($value);
    $paymentController = new \Modules\Account\Http\Controllers\AccountController;
    //$paymentController->performPayment($student, $value, App\User::find(1));
});
