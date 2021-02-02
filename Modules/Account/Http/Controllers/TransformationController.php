<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Transformation; 

class TransformationController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        //->where('is_academic_year_expense', '!=', '1')
        $resources = Transformation::with(['bank', 'store', 'user'])->latest()->get();
        return $resources;
    }
     
    /**
     * Transformation a newly created resource in storage.
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
            if (isset($data['attachment']))
                unset($data['attachment']);
            
            $resource = Transformation::create($data); 
            
            if ($request->type == 'bank_to_store') {
                $resource->bank()->first()->decrement('balance', $request->value);
                $resource->store()->first()->increment('balance', $request->value);
            }
            
            if ($request->type == 'store_to_bank') {
                $resource->store()->first()->decrement('balance', $request->value);
                $resource->bank()->first()->increment('balance', $request->value);
            }
            
            uploadImg($request->file('attachment'), "/uploads/transformation/", function($filename) use ($resource) {
                $resource->update([
                    "attachment" => $filename
                ]);
            });
            
            
            watch(__('add transformation ') . $resource->date, "fa fa-trophy");
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
    public function update(Request $request, Transformation $transformation) {
        try { 
            //restore old value  
            if ($transformation->type == 'bank_to_store') {
                $transformation->bank()->first()->increment('balance', $transformation->value);
                $transformation->store()->first()->decrement('balance', $transformation->value);
            }
            
            if ($transformation->type == 'store_to_bank') {
                $transformation->store()->first()->increment('balance', $transformation->value);
                $transformation->bank()->first()->decrement('balance', $transformation->value);
            }
            
            $data = $request->all();
            if (isset($data['attachment']))
                unset($data['attachment']);
            
            $transformation->update($data);
            
            
            if ($request->type == 'bank_to_store') {
                $transformation->bank()->first()->decrement('balance', $request->value);
                $transformation->store()->first()->increment('balance', $request->value);
            }
            
            if ($request->type == 'store_to_bank') {
                $transformation->store()->first()->decrement('balance', $request->value);
                $transformation->bank()->first()->increment('balance', $request->value);
            }
            
            uploadImg($request->file('attachment'), "/uploads/transformation/", function($filename) use ($transformation) {
                $transformation->update([
                    "attachment" => $filename
                ]);
            },"/uploads/transformation/" .$transformation->attachment);
            
            watch(__('edit transformation ') . $transformation->date, "fa fa-trophy");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $transformation->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Transformation $transformation) { 
        try { 
            watch(__('remove transformation ') . $transformation->name, "fa fa-trophy"); 
            $transformation->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
