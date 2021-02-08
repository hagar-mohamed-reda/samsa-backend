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

        // stores routes
        Route::get('banks', 'BankController@index');
        Route::post('banks/store', 'BankController@bank');
        Route::post('banks/update/{bank}', 'BankController@update');
        Route::post('banks/delete/{bank}', 'BankController@destroy');
 
        // trees routes
        Route::get('trees', 'TreeController@index');
        Route::post('trees/store', 'TreeController@tree');
        Route::post('trees/update/{tree}', 'TreeController@update');
        Route::post('trees/delete/{tree}', 'TreeController@destroy');
 
        // checks routes
        Route::get('checks', 'CheckController@index');
        Route::post('checks/store', 'CheckController@store');
        Route::post('checks/update/{check}', 'CheckController@update');
        Route::post('checks/delete/{check}', 'CheckController@destroy');
        
        // dailess routes
        Route::get('dailys', 'DailyController@index');
        Route::post('dailys/store', 'DailyController@store');
        Route::post('dailys/update/{daily}', 'DailyController@update');
        Route::post('dailys/delete/{daily}', 'DailyController@destroy');
        
        // Transformations routes
        Route::get('transformations', 'TransformationController@index');
        Route::post('transformations/store', 'TransformationController@store');
        Route::post('transformations/update/{transformation}', 'TransformationController@update');
        Route::post('transformations/delete/{transformation}', 'TransformationController@destroy');
        
        // custody routes
        Route::get('custodys', 'CustodyController@index');
        Route::post('custodys/store', 'CustodyController@store');
        Route::post('custodys/update/{custody}', 'CustodyController@update');
        Route::post('custodys/delete/{custody}', 'CustodyController@destroy');
        
        // solfa routes
        Route::get('solfas', 'SolfaController@index');
        Route::post('solfas/store', 'SolfaController@store');
        Route::post('solfas/update/{solfa}', 'SolfaController@update');
        Route::post('solfas/delete/{solfa}', 'SolfaController@destroy');
        
        // income routes
        Route::get('incomes', 'IncomeController@index');
        Route::get('balances', 'BalanceController@index');
        Route::get('bank-balances', 'BalanceController@bankBalance');
        
        // academic_year_expense routes
        Route::get('academic_year_expenses', 'AcademicYearExpenseController@index');
        Route::get('academic_year_expenses_details', 'AcademicYearExpenseController@details');
        Route::post('academic_year_expenses/store', 'AcademicYearExpenseController@store');
        Route::post('academic_year_expenses/update', 'AcademicYearExpenseController@update');
        Route::post('academic_year_expenses/delete/{resource}', 'AcademicYearExpenseController@destroy');

        // report
        Route::get('report/payment-details', 'ReportController@paymentDetails');
        Route::get('report/student-balances', 'ReportController@studentBalances');
        Route::get('report/get-report-creator-info', 'ReportController@reportCreator');
        Route::get('report/get-student-installment', 'ReportController@studentInstallment');
        Route::get('report/get-student-discount', 'ReportController@studentDiscounts');

        // account routes
        Route::get('get_student_account', 'AccountController@getStudentAccounting');
        Route::get('get_available_services', 'AccountController@getStudentAvailableServices');
        Route::post('pay', 'AccountController@pay');
        Route::post('pay-refund', 'AccountController@refund');
        Route::post('pay-remove', 'AccountController@removePayment');
        Route::post('edit-payment', 'AccountController@editPayment');
        Route::post('write_notes', 'AccountController@writeStudentNote');
        Route::post('update_student_info', 'AccountController@updateStudentInfo');
        Route::post('create_balance_reset', 'AccountController@createBalanceReset');

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
        Route::get('discount_requests', 'DiscountRequestController@index');
        Route::post('discount_requests/store', 'DiscountRequestController@store');
        Route::post('discount_requests/delete/{resource}', 'DiscountRequestController@destroy');
        Route::get('discount_requests/receipt/{resource}', 'ReceiptController@getDiscountRequestReceipt');

        // discount  routes
        Route::get('discounts', 'DiscountController@index');
        Route::post('discounts/store', 'DiscountController@store');

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
