<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\StudentCodeSeries;
use Modules\Settings\Http\Requests\StudentCodeSeriesRequest;

class StudentCodeSeriesController extends Controller
{

    public function __construct() {
        $this->middleware(['permission:student-code-series_read'])->only('index');
        $this->middleware(['permission:student-code-series_create'])->only('create');
        $this->middleware(['permission:student-code-series_update'])->only('edit');
        $this->middleware(['permission:student-code-series_delete'])->only('destroy'); 
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $query = StudentCodeSeries::query();

        if (request()->level_id > 0)
            $query->where('level_id', request()->level_id);

        if (request()->academic_year_id > 0)
            $query->where('academic_year_id', request()->academic_year_id);

        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('settings::student_code_series.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::student_code_series.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StudentCodeSeriesRequest $request) {
        try {
            $resource = StudentCodeSeries::create($request->all());
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add student code series'), __('add student code series') . $resource->code, "fa fa-barcode");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('student-code-series.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = StudentCodeSeries::find($id);
        return view('settings::student_code_series.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(StudentCodeSeriesRequest $request, $id) {
        try {
            $resource = StudentCodeSeries::find($id);
            $resource->update($request->all());
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit student code series'), __('edit student code series') . $resource->code, "fa fa-barcode");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('student-code-series.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = StudentCodeSeries::find($id);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove student code series'), __('remove student code series of id ') . $resource->id, "fa fa-barcode");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('student-code-series.index');
    }
}
