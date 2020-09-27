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
        $resources = Service::with(['level', 'division', 'store'])->latest()->get();
        return $resources;
    }
 
    /**
     * Service a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function store(Request $request) {
        $resource = null;
        try { 
              
            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [
                "name" =>  "required|unique:account_services",
                "value" =>  "required",   
                "type" =>  "required", 
            ], [
                "name.unique" => __('name already exist'),
                "name.required" => __('fill all required data'),
                "value.required" => __('fill all required data'), 
                "type.required" => __('fill all required data'),
            ]);
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            $data = $request->all(); 
             
            $resource = Service::create($data); 
            watch(__('add service ') . $resource->name, "fa fa-trophy");
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
    public function update(Request $request, Service $service) {
        try { 
            $service->update($request->all());
            watch(__('edit service ') . $service->name, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $service->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Service $service) { 
        try { 
            watch(__('remove service ') . $service->name, "fa fa-trophy"); 
            $service->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
