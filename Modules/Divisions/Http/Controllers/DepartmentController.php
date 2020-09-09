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
        $departments = Department::OrderBy('created_at', 'desc')->get();
        return view('divisions::departments.index', compact('departments'));
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
    public function store(DepartmentRequest $request)
    {
        try {
            $department = Department::create($request->all());
            if($department){
                notify()->success( __('data created successfully'), "", "bottomLeft" );
                return redirect()->route('departments.index');
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft" );
                return redirect()->route('departments.index')->with(['error' => 'هناك خطأ ما يرجى المحاولة فى وقت لاحق']);
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft" );
            return redirect()->route('departments.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('divisions::show');
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
    public function update(DepartmentRequest $request, $id)
    {
        try {
            $department = Department::find($id);
            if (!$department) {
                notify()->warning( __('data not found'), "", "bottomLeft" );
                return redirect()->route('departments.index');
            } else {
                $department->update($request->all());
                notify()->success( __('data updated successfully'), "", "bottomLeft");
                return redirect()->route('departments.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('departments.index');
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
                notify()->warning(__('data not found'), "", "bottomLeft" );
                return redirect()->route('departments.index');
            }
            if(isset($divisions) && $divisions > 0){
                 notify()->error(__('this item can not be deleted'), "", "bottomLeft" );
                return redirect()->route('departments.index');
            }
            $department->delete();
            notify()->success( __('data deleted successsfully'), "", "bottomLeft");
            return redirect()->route('departments.index');
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('departments.index');
        }
    }
    public function getDepartments($level_id){
        return  Department::where('level_id', $level_id)->pluck('id','name')->toArray();
    }
}
