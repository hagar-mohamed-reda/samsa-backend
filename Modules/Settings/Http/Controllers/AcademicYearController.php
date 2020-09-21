<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\AcademicYear;
use Modules\Settings\Http\Requests\AcademicYearRequest;

class AcademicYearController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:academic-years_read'])->only('index');
//        $this->middleware(['permission:academic-years_create'])->only('create');
//        $this->middleware(['permission:academic-years_update'])->only('edit');
//        $this->middleware(['permission:academic-years_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $academic_years = AcademicYear::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $academic_years);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::academic_years.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'start_date' => 'required|unique:academic_years,start_date',
            'end_date' => 'required|unique:academic_years,end_date',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $data = $request->all();
//            return responseJson(1, __('hahaha'),  $request->all());
            $data['name'] = date('Y', strtotime($data['start_date'])) . "-" . date('Y', strtotime($data['end_date']));
            $academic_years_name = AcademicYear::all()->pluck('name');
            $academic_years_name = $academic_years_name->toArray();

            if (in_array($data['name'], $academic_years_name)) {
                return responseJson(0, __('this academic year is already exists'), null);

            } else {
                $academic_year = AcademicYear::create($data);
                if ($academic_year) {
//                    log(_('Academic year was created'), $icon = 'fa fa-accusoft');
                    return responseJson(1, __('data created successfully'), $academic_year);
                }
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $academic_year = AcademicYear::find($id);
        if (!$academic_year) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $academic_year);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'start_date' => 'required|unique:academic_years,id',
            'end_date' => 'required|unique:academic_years,id',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $academic_year = AcademicYear::find($id);
            $data = $request->all();
            $data['name'] = date('Y', strtotime($data['start_date'])) . "-" . date('Y', strtotime($data['end_date']));
            $academic_years_name = AcademicYear::all()->pluck('name');
            $academic_years_name = $academic_years_name->toArray();

            if (!$academic_year) {
                return responseJson(0, __('data not found'), '');
            } else {
                if ($data['name'] == $academic_year->name) {
                    $academic_year->update($data);
                    return responseJson(1, __('data updated successfully'), $academic_year);
                } else {
                    if (in_array($data['name'], $academic_years_name)) {
                        return responseJson(0, __('this academic year is already exists'), null);
                    }
                }
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
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
            $academic_year = AcademicYear::find($id);
            $qualificationTypes = $academic_year->qualificationTypes->count();

            if (!$academic_year) {
                return responseJson(0, __('data not found'), '');
            }
            if ((isset($qualificationTypes) && $qualificationTypes > 0) ||
                $academic_year->applications->count() > 0 ||
                $academic_year->students->count() > 0 ||
                $academic_year->militaryCourseCollection->count() > 0 ||
                $academic_year->studentCodeSeries->count() > 0
            ) {
                return responseJson(0, __('this item can not be deleted'), $academic_year->fresh());
            } else {
                $academic_year->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

}
