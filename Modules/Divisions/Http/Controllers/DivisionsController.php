<?php

namespace Modules\Divisions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Divisions\Entities\Division;
use Modules\Divisions\Http\Requests\DivisionRequest;

use Modules\Divisions\Entities\Department;

class DivisionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $query = Division::query();
        
        if (request()->level_id > 0) {
            $departIds = Department::where('level_id', request()->level_id)->get('id')->pluck('id')->toArray();
            $query->whereIn('department_id', $departIds);
        }
        
        if (request()->department_id > 0) 
            $query->where('department_id', request()->department_id);
        
        $divisions = Division::with(['department'])->OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $divisions);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('divisions::divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $validator = validator($request->all(), [
            "name" => "required",
            'department_id'=>'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }

        try {
            $division = Division::create($request->all());
            if($division){
                return responseJson(1, __('data created successfully'), $division);
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('divisions.index');
            }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(),"");
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id){
        $division = Division::find($id);
        $division->department;
        if (!$division) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $division);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id){
        $devision = Division::find($id);
        if (!$devision) {
            notify()->error( __('data not found'), "", "bottomLeft");
            return redirect()->route('divisions.index');
        }
        return view('divisions::divisions.edit', compact('devision'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(DivisionRequest $request, $id){
        $validator = validator($request->all(), [
            "name" => "required",
            'department_id'=>'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $division = Division::find($id);
            if (!$division) {
                return responseJson(0, __('data not found'), '');
            } else {
                $division->update($request->all());
                return responseJson(1, __('data updated successfully'), $division);
            }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id){
        $division = Division::find($id);
        if (!$division) {
            return responseJson(0, __('data not found'), '');
        }
        try {
            $division->delete();
            return responseJson(1, __('deleted successfully'), '');
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "");
        }
    }
        
    
}
