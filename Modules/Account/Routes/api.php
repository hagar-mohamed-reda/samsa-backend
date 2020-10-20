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
        Route::get('academic_year_expenses_details', 'AcademicYearExpenseController@details');
        Route::post('academic_year_expenses/store', 'AcademicYearExpenseController@store');
        Route::post('academic_year_expenses/update', 'AcademicYearExpenseController@update');
        Route::post('academic_year_expenses/delete/{resource}', 'AcademicYearExpenseController@destroy');

        // report
        Route::get('report/payment-details', 'ReportController@paymentDetails');

        // account routes
        Route::get('get_student_account', 'AccountController@getStudentAccounting');
        Route::get('get_available_services', 'AccountController@getStudentAvailableServices');
        Route::post('pay', 'AccountController@pay');
        Route::post('pay-refund', 'AccountController@refund');
        Route::post('pay-remove', 'AccountController@removePayment');
        Route::post('edit-payment', 'AccountController@editPayment');
        Route::post('write_notes', 'AccountController@writeStudentNote');
        Route::post('update_student_info', 'AccountController@updateStudentInfo');

        // installment routes
        Route::get('installment/get', 'InstallmentController@index');
        Route::post('installment/update', 'InstallmentController@update');

        // payment receipt
        Route::get('payment_receipt', 'PaymentController@getPaymentReceipt');

        // main
        Route::get('search_student', 'AccountController@searchStudent');

        // account setting
        Route::post('update_setting', 'AccountController@updateAccountSetting');
        Route::get('get_settings', 'AccountController@getSettings');


        Route::get('levels', function(){
          return DB::table('levels')->get();
        });
        Route::get('divisions', function(){
          return DB::table('divisions')
          ->get();
        });
        Route::get('terms', function(){
          return DB::table('terms')->get();
        });

        //

        // discount types routes
        Route::get('discount_types', 'DiscountTypeController@index');
        Route::post('discount_types/store', 'DiscountTypeController@store');
        Route::post('discount_types/update/{discountType}', 'DiscountTypeController@update');
        Route::post('discount_types/delete/{discountType}', 'DiscountTypeController@destroy');

        // discount request
        Route::post('create_discount_request', 'AccountController@createDiscountRequest');
        Route::get('discount_requests/receipt/{resource}', 'ReceiptController@getDiscountRequestReceipt');

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
