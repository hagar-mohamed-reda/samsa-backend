<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\DegreeMap;


class DegreeMapController extends Controller
{
    /**
     * return list of degree maps
     * @return Response
     */
    public function get()
    {
        return DegreeMap::latest()->get();
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
                'percent_from' => "required",   
		        'percent_to' => "required",    
		        'key' => "required",    
		        'gpa' => "required",    
		        'name' => "required"
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all();

            $resource = DegreeMap::create($data);

            watch(__('create new degree map ') . $resource->name, "fa fa-th-list");
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
    public function update(Request $request, DegreeMap $resource)
    { 
        try {
            $validator = validator($request->all(), [
                'percent_from' => "required",   
                'percent_to' => "required",    
                'key' => "required",    
                'gpa' => "required",    
                'name' => "required"
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all(); 
            $resource->update($data);
            watch(__('update degree map ') . $resource->name, "fa fa-th-list");

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
    public function destroy(DegreeMap $resource)
    {
        if ($resource->can_delete) {
            watch(__('remove degree map ') . $resource->name, "fa fa-th-list");
        	$resource->delete();
        }
        return responseJson(1, __('done'));
    }
 
}
