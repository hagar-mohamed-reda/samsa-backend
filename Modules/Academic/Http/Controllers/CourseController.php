<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\Course;
use Modules\Academic\Entities\CoursePrerequsite;


class CourseController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        return Course::latest()->get();
    }
      
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $resource = null;

        $relatedCourses = explode(",", $request->prequsites);

        try {
            $validator = validator($request->all(), [
                'name' => "required",   
		        'code' => "required",    
		        'code' => "required",    
		        'year_work_degree' => "required",    
		        'practical_degree' => "required",    
		        'academic_degree' => "required",   
		        'division_id' => "required", 
		        'credit_hour' => "required",  
		        'subject_category_id' => "required",  
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all();

            $resource = Course::create($data);

            foreach($relatedCourses as $item) {
                if ($item > 0)
                CoursePrerequsite::create([
                    "course_id" => $resource->id,
                    "related_course_id" => $item
                ]);
            }

            watch(__('create new course ') . $resource->name, "fa fa-book");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
    }
 
 

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Course $resource)
    {  
        try {
            $validator = validator($request->all(), [
                'name' => "required",   
		        'code' => "required",    
		        'code' => "required",    
		        'year_work_degree' => "required",    
		        'practical_degree' => "required",    
		        'academic_degree' => "required",   
		        'division_id' => "required", 
		        'credit_hour' => "required",  
		        'subject_category_id' => "required",  
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all(); 
            $resource->update($data);

            $resource->prequsitesCourse()->delete();
            foreach($request->prerequsites as $item) { 
                CoursePrerequsite::create([
                    "course_id" => $resource->id,
                    "related_course_id" => $item
                ]);
            }

            watch(__('update course ') . $resource->name, "fa fa-book");

        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Course $resource)
    {
        if ($resource->can_delete) {
            watch(__('remove course ') . $resource->name, "fa fa-book");
        	$resource->delete();
        }
        return responseJson(1, __('done'));
    }
 
}
