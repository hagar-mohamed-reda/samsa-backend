<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Qualification;
use Modules\Settings\Http\Requests\QualificationRequest;

class QualilificationController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:qualifications_read'])->only('index');
//        $this->middleware(['permission:qualifications_create'])->only('create');
//        $this->middleware(['permission:qualifications_update'])->only('edit');
//        $this->middleware(['permission:qualifications_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $qualifications = Qualification::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $qualifications);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::qualifications.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|unique:qualifications,name',
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $data = $request->all();
            if ($request->has('is_azhar')) {
                $data['is_azhar'] = '1';
            } else {
                $data['is_azhar'] = '0';
            }
            $qualification = Qualification::create($data);
            if ($qualification) {
                return responseJson(1, __('data created successfully'), $qualification);
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('qualifications.index');
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
        $qualification = Qualification::find($id);
        if (!$qualification) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $qualification);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $qualification = Qualification::select()->find($id);
        if (!$qualification) {

            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('qualifications.index');
        }
        return view('settings::qualifications.edit', compact('qualification'));
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
            'name' => 'required|unique:qualifications,name,'.$id,
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $data = $request->all();
            if ($request->has('is_azhar')) {
                $data['is_azhar'] = $request->is_azhar;
            }
            $qualification = Qualification::find($id);

            if (!$qualification) {
                return responseJson(0, __('data not found'), '');
            } else {
                $qualification->update($data);
                return responseJson(1, __('data updated successfully'), $qualification);
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
            $setting = Qualification::find($id);
            if (!$setting) {
                return responseJson(0, __('data not found'), '');
            }

            $qualification_types = $setting->qualification_types();

            if (isset($qualification_types) && $qualification_types->count() > 0) {
                return responseJson(0, __('this item can not be deleted'), $setting->fresh());
            } else {
                $setting->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

}
