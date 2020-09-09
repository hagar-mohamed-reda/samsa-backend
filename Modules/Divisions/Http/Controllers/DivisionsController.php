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
    public function index()
    {
        $query = Division::query();
        
        if (request()->level_id > 0) {
            $departIds = Department::where('level_id', request()->level_id)->get('id')->pluck('id')->toArray();
            $query->whereIn('department_id', $departIds);
        }
        
        if (request()->department_id > 0) 
            $query->where('department_id', request()->department_id);
        
        $divisions = $query->OrderBy('created_at', 'desc')->get();
        return view('divisions::divisions.index', compact('divisions'));
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
    public function store(DivisionRequest $request)
    {
        try {
            $division = Division::create($request->all());
            if($division){
                notify()->success( __('data created successfully'), "", "bottomLeft");
                return redirect()->route('divisions.index');
            }else{
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('divisions.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('divisions.index');
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
    public function update(DivisionRequest $request, $id)
    {
        try {
            $division = Division::find($id);
            if (!$division) {
                notify()->error( __('data not found'), "", "bottomLeft");
                return redirect()->route('divisions.index');
            } else {
                $division->update($request->all());
                notify()->success( __('data updated successfully'), "", "bottomLeft");
                return redirect()->route('divisions.index');
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('divisions.index');
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
            $division = Division::find($id);
            if (!$division) {
                notify()->warning( __('data not found'), "", "bottomLeft");
                return redirect()->route('divisions.index');
            }
            $division->delete();
            notify()->success( __('data deleted successfully'), "", "bottomLeft");
            return redirect()->route('divisions.index');
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('divisions.index');}

    }
}
