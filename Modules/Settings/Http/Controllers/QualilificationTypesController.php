<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\QualificationTypes;
use Modules\Settings\Http\Requests\QualificationTypeRequest;

class QualilificationTypesController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:qualification-types_read'])->only('index');
//        $this->middleware(['permission:qualification-types_create'])->only('create');
//        $this->middleware(['permission:qualification-types_update'])->only('edit');
//        $this->middleware(['permission:qualification-types_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $query = QualificationTypes::query();

        if (request()->level_id > 0)
            $query->where('level_id', request()->level_id);

        if (request()->academic_year_id > 0)
            $query->where('academic_year_id', request()->academic_year_id);

        $qualification_types = $query->OrderBy('created_at', 'desc')->paginate(10);
        return responseJson(1, "ok", $qualification_types);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::qualification_types.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'grade' => 'required',
            'qualification_id' => 'required|exists:qualifications,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'percentage' => 'required',
            'level_id' => 'required|exists:levels,id',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $qualification_type = QualificationTypes::create($request->all());
            if ($qualification_type) {
                watch('qualification type was created', '');
                return responseJson(1, __('data created successfully'), $qualification_type);
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('qualification-types.index');
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
        $qualification_type = QualificationTypes::find($id);
        if (!$qualification_type) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $qualification_type);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $qualification = QualificationTypes::select()->find($id);
        if (!$qualification) {

            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('qualification-types.index');
        }

        return view('settings::qualification_types.edit', compact('qualification'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $qualification = QualificationTypes::find($id);
        if (!$qualification) {
            notify()->warning(__('data not found'), "", "bottomLeft");
        }
        $validator = validator($request->all(), [
            'name' => 'required',
            'grade' => 'required',
            'qualification_id' => 'required|exists:qualifications,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'percentage' => 'required',
            'level_id' => 'required|exists:levels,id',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $qualification->update($request->all());
            return responseJson(1, __('data updated successfully'), $qualification);
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
            $setting = QualificationTypes::find($id);
            if (!$setting) {
                return responseJson(0, __('data not found'), '');
            } else {
                $setting->applications->count();
                if($setting->applications->count() > 0 || $setting->students->count() > 0)
                    return responseJson(0, __('this item can not be deleted'), $setting->fresh());

                $setting->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

}
