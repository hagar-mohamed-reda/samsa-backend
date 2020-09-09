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


Route::prefix('account')->group(function() {

    Route::group(['middleware' => 'auth:web'], function() {
        Route::resource('stores', 'StoreController');
        Route::resource('banks', 'BankController');
        Route::resource('transformations', 'TransformationController');
        Route::resource('deposites', 'DepositeController');
        Route::resource('expense_maincategorys', 'ExpenseMainCategoryController');
        Route::resource('expense_subcategorys', 'ExpenseSubCategoryController');
        Route::resource('installments', 'InstallmentController');
        Route::resource('plans', 'PlanController');
        Route::resource('rewords', 'RewordController');
        Route::resource('fines', 'FineController');
        Route::resource('payments', 'PaymentController');
        Route::resource('dailys', 'DailyController');
        //
        Route::get('installments/install/{installment}', 'InstallmentController@install')->name('installments.install');
        Route::get('installments/pay/{installment}', 'InstallmentController@pay')->name('installments.pay');
        Route::post('installments/install/{installment}', 'InstallmentController@storeInstall')->name('installments.storeInstall');
        Route::post('installments/pay/{installment}', 'InstallmentController@storePay')->name('installments.storePay');


        // tree
        Route::get('/trees', 'TreeController@index')->name('tree.index'); 
    });
});
