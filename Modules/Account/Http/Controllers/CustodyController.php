<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Custody; 

class CustodyController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = Custody::latest()->where('store_id', request()->store_id)->get();
        return $resources;
    }
 
    /**
     * Custody a newly created resource in storage.
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
            $data = $request->all();
            $data['user_id'] = $request->user->id; 
             
            $resource = Custody::create($data); 
            watch(__('add Custody ') . $resource->name, "fa fa-custody");
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
    public function update(Request $request, Custody $Custody) {
        try { 
            $data = $request->all();
            $data['user_id'] = $request->user->id; 
            $Custody->update($data);
            watch(__('edit Custody ') . $Custody->name, "fa fa-custody");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $Custody->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Custody $custody) { 
        try { 
            watch(__('remove Custody ') . $custody->name, "fa fa-custody"); 
            $custody->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
