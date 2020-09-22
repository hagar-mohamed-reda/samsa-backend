<?php

namespace Modules\Divisions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Divisions\Entities\Department;
use Modules\Divisions\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $departments = Department::with(['level'])->OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $departments);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('divisions::departments.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            'level_id'=>'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $department = Department::create($request->all());
            if($department){
                return responseJson(1, __('data created successfully'), $department);
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft" );
                return redirect()->route('departments.index')->with(['error' => 'هناك خطأ ما يرجى المحاولة فى وقت لاحق']);
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
    public function show($id)
    {
        $department = Department::find($id);
        $department->level;
        if (!$department) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $department);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $department = Department::find($id);
        if (!$department) {
            notify()->warning( __('data not found'), "", "bottomLeft" );
            return redirect()->route('departments.index');
        }
        return view('divisions::departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            'level_id'=>'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $department = Department::find($id);
            if (!$department) {
                return responseJson(0, __('data not found'), '');
            } else {
                $department->update($request->all());
                return responseJson(1, __('data updated successfully'), $department);

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
    public function destroy($id)
    {
        try {
            $department = Department::find($id);
            $divisions = $department->division->count();
            if (!$department) {
                return responseJson(0, __('data not found'), '');

            }
            if(isset($divisions) && $divisions > 0){
                 return responseJson(0,__('this item can not be deleted'), '');
            }
            $department->delete();
            return responseJson(1, __('deleted successfully'), '');

        } catch (\Exception $th) {
            return responseJson(0, $ex->getMessage(), "");
        }
    }
    public function getDepartments($level_id){
        $departments = Department::where('level_id', $level_id)->get();
        return responseJson(1,'ok', $departments);

    }
}
