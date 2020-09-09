<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Service; 

class ServiceController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = Service::with(['level', 'division'])->get();
        return responseJson(1, "", $resources);
    }
 
    /**
     * Service a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function store(Request $request) {
        try {
            $validator = validator($request->all(), [
                "name" =>  "required|unique:account_services",
                "value" =>  "required",
                "except_level_id" =>  "required",
                "division_id" =>  "required",
                "store_id" =>  "required",
                "additional_value" =>  "required",
                "type" =>  "required", 
            ]);
            
            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
            
            $resource = Service::create($request->all()); 
            log(__('add service ') . $resource->name, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'));
    }
  

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $resource = Service::find($id);
            $resource->update($request->all());
            log(__('edit service ') . $resource->name, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) { 
        try {
            $resource = Service::find($id);   
            log(__('remove service ') . $resource->name, "fa fa-trophy"); 
            $resource->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
