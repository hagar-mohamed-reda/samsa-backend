<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Daily; 

class DailyController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $query = Daily::with(['bank', 'store', 'user'])
                ->where('store_id', request()->store_id);
        
        if (request()->date_from && request()->date_to) {
            $query->whereBetween("date", [request()->date_from, request()->date_to]);
        }
        
        $resources = $query->get();
        return $resources;
    }
     
    /**
     * Daily a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function store(Request $request) {
        $resource = null;
        try { 
              
            //return dump(toClass($data)->api_token);
            $validator = validator($request->all(), [ 
                "date" =>  "required",   
                "value" =>  "required", 
            ] );
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            $data = $request->all();
            $data['user_id'] = optional($request->user)->id;
            $resource = Daily::create($data); 
            
            if ($request->type == 'bank') {
                $resource->bank()->first()->decrement('balance', $request->value);
            }
            
            if ($request->type == 'store') {
                $resource->store()->first()->decrement('balance', $request->value);
            }
            
            
            
            watch(__('add daily ') . $resource->name, "fa fa-trophy");
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
    public function update(Request $request, Daily $daily) {
        try { 
            //restore old value  
            if ($daily->type == 'bank') {
                $daily->bank()->first()->increment('balance', $daily->value);
            } 
            if ($daily->type == 'store') {
                $daily->store()->first()->increment('balance', $daily->value);
            }
            
            $daily->update($request->all());
            
            if ($request->type == 'bank') {
                $daily->bank()->first()->decrement('balance', $request->value);
            }
            
            if ($request->type == 'store') {
                $daily->store()->first()->decrement('balance', $request->value);
            }
            
            watch(__('edit daily ') . $daily->name, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $daily->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Daily $daily) { 
        try { 
            watch(__('remove daily ') . $daily->name, "fa fa-trophy"); 
            $daily->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
