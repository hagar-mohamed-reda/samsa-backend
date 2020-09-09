<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\AcademicYear;
use Modules\Settings\Http\Requests\AcademicYearRequest;

class AcademicYearController extends Controller {

    public function __construct() {
        $this->middleware(['permission:academic-years_read'])->only('index');
        $this->middleware(['permission:academic-years_create'])->only('create');
        $this->middleware(['permission:academic-years_update'])->only('edit');
        $this->middleware(['permission:academic-years_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $academic_years = AcademicYear::OrderBy('created_at', 'desc')->get();
        return view('settings::academic_years.index', compact('academic_years'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::academic_years.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(AcademicYearRequest $request) {
        try {
            $data = $request->all();
            $data['name'] = date('Y', strtotime($data['start_date'])) . "-" . date('Y', strtotime($data['end_date']));
            $academic_years_name = AcademicYear::all()->pluck('name');
            $academic_years_name = $academic_years_name->toArray();

            if (in_array($data['name'], $academic_years_name)) {
                notify()->error(__('this academic year is already exists'), "", "bottomLeft");
                return redirect()->back();
            } else {
                $academic_year = AcademicYear::create($data);
                if ($academic_year) {
                    notify()->success(__('data created successfully'), "", "bottomLeft");
                    return redirect()->route('academic-years.index');
                }
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('academic-years.index');
        }
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
        try {
            $academic_year = AcademicYear::select()->find($id);
            if (!$academic_year) {
                notify()->warning("هذه الاعدادات غير موجودة !", "", "bottomLeft");
                return redirect()->route('academic-years.index');
            } else {
                return view('settings::academic_years.edit', compact('academic_year'));
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
            return redirect()->route('academic-years.index');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(AcademicYearRequest $request, $id) {
        try {
            $academic_year = AcademicYear::find($id);
            $data = $request->all();
            $data['name'] = date('Y', strtotime($data['start_date'])) . "-" . date('Y', strtotime($data['end_date']));
            $academic_years_name = AcademicYear::all()->pluck('name');
            $academic_years_name = $academic_years_name->toArray();

            if (!$academic_year) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                if ($data['name'] == $academic_year->name) {
                    $academic_year->update($data);
                    notify()->success(__('data updated successfully'), "", "bottomLeft");
                } else {

                    if (in_array($data['name'], $academic_years_name)) {
                        notify()->error('this academic year is already exists', "", "bottomLeft");
                        return redirect()->back();
                    }
                }
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
        return redirect()->route('academic-years.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $academic_year = AcademicYear::find($id);
            $qualificationTypes = $academic_year->qualificationTypes->count();

            if (!$academic_year) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('academic-years.index');
            } 
            if(isset($qualificationTypes) && $qualificationTypes > 0){
                 notify()->error(__('this item can not be deleted'), "", "bottomLeft" );
                return redirect()->route('academic-years.index');
            }else {

                $academic_year->delete();
                notify()->success(__('data deleted successfully'), "", "bottomLeft");
                return redirect()->route('academic-years.index');
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
            return redirect()->route('academic-years.index');
        }
    }

}
