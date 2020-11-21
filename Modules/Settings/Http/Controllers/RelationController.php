<?php

namespace Modules\Settings\Http\Controllers;
 
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\Entities\Relation;

class RelationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Relation::latest()->get(); 
        return $query;
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|unique:parent_relation_type,name,".$request->id,
        ]); 
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), "");
        }
        try {
            $resource = Relation::create($request->all()); 
            watch("add relation " . $resource->name, "fa fa-code-fork");
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage()); 
        }
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relation $resource)
    {
        $validator = validator($request->all(), [
            "name" => "required|unique:parent_relation_type,name,".$request->id,
        ]); 
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), "");
        }
        try {
            $resource->update($request->all()); 
            watch("edit relation " . $resource->name, "fa fa-code-fork");
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage()); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Relation $resource)
    { 
        try { 
            watch("remove relation " . $resource->name, "fa fa-code-fork");
            $resource->delete();
            return responseJson(1, __('done'));
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage()); 
        } 
    }
}
