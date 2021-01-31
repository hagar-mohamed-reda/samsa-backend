<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Imports\CourseImport;
use App\Imports\CourseRegisterWithResultImport;
use Excel;

class ImportController extends Controller
{
    
    /**
     * import excel file
     * for students 
     * [code, set_number, student_name]
     * 
     */
    public function importStudents(Request $request) { 
        try {
            Excel::import(new StudentImport, $request->file('file'));
            return responseJson(1, __("done"));
        } catch (\Exception $exc) { 
            return responseJson(0, $exc->getMessage());
        } 
    }
    
    
    /**
     * import excel file
     * for courses 
     * [code, course_name]
     * 
     */
    public function importCourses(Request $request) { 
        try {
            Excel::import(new CourseImport, $request->file('file'));
            return responseJson(1, __("done"));
        } catch (\Exception $exc) { 
            return responseJson(0, $exc->getMessage());
        } 
    }
    
    
    /**
     * import excel file
     * for courses 
     * [code, course_name]
     * 
     */
    public function importResult(Request $request) { 
        try {
            Excel::import(new CourseRegisterWithResultImport, $request->file('file'));
            return responseJson(1, __("done"));
        } catch (\Exception $exc) { 
            return responseJson(0, $exc->getMessage());
        } 
    }
}
