<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\CourseCategory;


class CourseCategoryController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        return CourseCategory::with(['courses'])->latest()->get();
    }
     

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $resource = null;
        try {
            $validator = validator($request->all(), [
                'name' => "required",   
		        'total_hours' => "required",    
		        'required_hours' => "required"    
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all();

            $resource = CourseCategory::create($data);

            watch(__('create new course category ') . $resource->name, "fa fa-cubes");
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
    public function update(Request $request, CourseCategory $resource)
    { 
        try {
            $validator = validator($request->all(), [
                'name' => "required",   
                'total_hours' => "required",    
                'required_hours' => "required"  
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all(); 
            $resource->update($data);
            watch(__('update course category ') . $resource->name, "fa fa-cubes");

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
    public function destroy(CourseCategory $resource)
    {
        if ($resource->can_delete) {
            watch(__('remove course category ') . $resource->name, "fa fa-cubes");
        	$resource->delete();
        }
        return responseJson(1, __('done'));
    }
 
}
