<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\OpenCourse; 
use Modules\Academic\Entities\Course; 
use Modules\Account\Entities\AccountSetting;
use Modules\Account\Entities\Student;
use Modules\Academic\Entities\StudentAvailableCourse;
use Modules\Academic\Entities\StudentRegisterCourse;


class StudentRegisterController extends Controller
{
    
    public function getCourses(Request $request)
    {
        $student = Student::find($request->student_id);
        $avaibleCourse = new StudentAvailableCourse($student);
        return $avaibleCourse->getCourses();
    }
    
    public function registerCourses(Request $request) {
        return StudentRegisterCourse::add($request);
    }
       
}
