<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\OpenCourse; 
use Modules\Account\Entities\AccountSetting;


class OpenCourseController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        return OpenCourse::currentCourses();
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
