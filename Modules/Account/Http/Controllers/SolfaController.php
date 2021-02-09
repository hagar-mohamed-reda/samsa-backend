<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Solfa; 

class SolfaController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = Solfa::latest()->where('store_id', request()->store_id)->get();
        return $resources;
    }
 
    /**
     * Solfa a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function store(Request $request) {
        $resource = null;
        try { 
              
            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [
                "name" =>  "required", 
                "value" =>  "required", 
                "store_id" =>  "required", 
                "date" =>  "required", 
            ]);
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            
            if (Solfa::getTotal($request) > $request->value) {
                return responseJson(0, __('sum of installments must equal ') . $request->value);
            }
            
            $data = $request->all();
            $data['user_id'] = $request->user->id;
             
            $resource = Solfa::create($data); 
            watch(__('add Solfa ') . $resource->name, "fa fa-solfa");
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
    public function update(Request $request, Solfa $Solfa) {
        try {  
            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [
                "name" =>  "required", 
                "value" =>  "required", 
                "store_id" =>  "required", 
                "date" =>  "required", 
            ]);
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            if (Solfa::getTotal($request) > $request->value) {
                return responseJson(0, __('sum of installments must equal ') . $request->value);
            }
            
            $data = $request->all();
            $data['user_id'] = $request->user->id; 
            $Solfa->update($data);
            watch(__('edit Solfa ') . $Solfa->name, "fa fa-solfa");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $Solfa->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Solfa $solfa) { 
        try { 
            watch(__('remove Solfa ') . $solfa->name, "fa fa-solfa"); 
            $solfa->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
