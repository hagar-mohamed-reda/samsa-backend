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

Route::prefix('academic')->group(function() {
    Route::get('/', 'AcademicController@index');
});

Route::group(['middleware' => 'api_auth'], function () {
    Route::prefix('academic')->group(function() {
        
        Route::get('/register-course-print/{student}', 'AcademicController@getRegisterCoursePrintPreview');
        Route::get('/register-course-user-print/{student}', 'AcademicController@getRegisterCourseUserPrintPreview');
        Route::get('/register-course-student-print/{student}', 'AcademicController@getRegisterCourseStudentPrintPreview');
    });
});


Route::get("/test_transfer", function(){
    $student = Modules\Academic\Entities\StudentResultTransfer::find(14);
    $student->checkIfCanTransferToAnotherLevel();
    echo  $student->getActualRegisterCourses()->count();
    echo "<br>";
    echo  $student->getActualRegisterCourses()->sum('credit_hour');
    echo "<br>";
    echo  $student->getStudentBalance()->getCurrentBalanceTotal();
    echo "<br>";
    
    echo $student->failedTransferReason;
});