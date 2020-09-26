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
        
        // stores routes
        Route::get('stores', 'StoreController@index');
        Route::post('stores/store', 'StoreController@store');
        Route::post('stores/update/{store}', 'StoreController@update');
        Route::post('stores/delete/{store}', 'StoreController@destroy');
        
        // academic_year_expense routes
        Route::get('academic_year_expenses', 'AcademicYearExpenseController@index');
        Route::post('academic_year_expenses/store', 'AcademicYearExpenseController@store');
        Route::post('academic_year_expenses/update', 'AcademicYearExpenseController@update');
        Route::post('academic_year_expenses/delete/{resource}', 'AcademicYearExpenseController@destroy');
        
        // account routes
        Route::get('get_student_account', 'AccountController@getStudentAccounting');
        Route::get('get_available_services', 'AccountController@getStudentAvailableServices');
        Route::post('pay', 'AccountController@pay');
        Route::post('write_notes', 'AccountController@writeStudentNote');
        
        // installment routes
        Route::get('installment/get', 'InstallmentController@index');
        Route::post('installment/update', 'InstallmentController@update');

        // main
        Route::get('search_student', 'AccountController@searchStudent');

        Route::get('levels', function(){
          return DB::table('levels')->get();
        });
        Route::get('divisions', function(){
          return DB::table('divisions')
          ->join('departments', 'departments.id', '=', 'divisions.department_id')
          ->join('levels', 'levels.id', '=', 'departments.level_id')
          ->get(['divisions.id as id ', 'divisions.name', 'levels.name as level', 'level_id']);
        });
        Route::get('terms', function(){
          return DB::table('terms')->get();
        });

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
