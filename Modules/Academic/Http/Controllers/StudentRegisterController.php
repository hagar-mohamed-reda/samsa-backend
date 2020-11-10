<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\OpenCourse; 
use Modules\Academic\Entities\Course; 
use Modules\Account\Entities\AccountSetting;
use Modules\Academic\Entities\StudentAvailableCourse;


class StudentRegisterController extends Controller
{
    
    public function getCourses(Request $request)
    {
        $student = Student::find($request->student_id); 
        $avaibleCourse = new StudentAvailableCourse($student);
        return $avaibleCourse->getCourses();
    }
      
     

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Course $resource)
    {  

        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();

        try { 
            // remove old 
            OpenCourse::currentOpenCourses()->delete();

            // add new
            foreach ($request->courses as $item) {
                OpenCourse::create([
                    "term_id" => $term->id,
                    "academic_year_id" => $year->id,
                    "date" => date('Y-m-d'),
                    "course_id" => $item['id']
                ]);
            }

            watch(__('open courses ') . $resource->name, "fa fa-book");

        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
        //
    }

    
 
}
