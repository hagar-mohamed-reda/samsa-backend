<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Check; 

class CheckController extends Controller
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
        $resources = Check::latest()->get();
        return $resources;
    }
 
    /**
     * Check a newly created resource in storage.
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
            if (isset($data['attachment']))
                unset($data['attachment']);
             
            $resource = Check::create($data); 
            $resource->bank()->first()->decrement("balance", $request->value);

            uploadImg($request->file('attachment'), "/uploads/check/", function($filename) use ($resource) {
                $resource->update([
                    "attachment" => $filename
                ]);
            },"/uploads/check/" .$resource->attachment);
            
            watch(__('add check ') . $resource->date, "fa fa-newspaper-o");
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
    public function update(Request $request, Check $check) {
        try { 
            
            $data = $request->all(); 
            if (isset($data['attachment']))
                unset($data['attachment']);
            
            // restore old balance
            $check->bank()->first()->increment("balance", $check->value);
            
            $check->update($data);
            
            // decrease old balance
            $check->bank()->first()->decrement("balance", $request->value);
            
            uploadImg($request->file('attachment'), "/uploads/check/", function($filename) use ($check) {
                $check->update([
                    "attachment" => $filename
                ]);
            },"/uploads/check/" . $check->attachment);
            
            watch(__('edit check ') . $check->date, "fa fa-newspaper-o");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $check->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Check $check) { 
        try { 
            watch(__('remove check ') . $check->name, "fa fa-newspaper-o"); 
            $check->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
