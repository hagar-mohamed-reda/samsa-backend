<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Academic\Entities\Student;

class AcademicController extends Controller
{
    
    /**
     * return student info
     *
     * @return type
     */
    public function getStudentInfo() {
        $student = null;
        if (request()->student_id) {
            $student = Student::query()
            ->with([
                'level', 'division', 'case_constraint', 
                'constraint_status', 'installments', 
                'payments', 'registerationStatus', 
                'nationality', 'discount_requests', 'balanceResets',
                'courses'
                ])
            ->find(request()->student_id);
        }

        $student->date = date("Y-m-d");
        return $student;
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('academic::index');
    }
 
}
