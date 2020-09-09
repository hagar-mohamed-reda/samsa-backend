<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Qualification;
use Modules\Settings\Http\Requests\QualificationRequest;

class QualilificationController extends Controller {

    public function __construct() {
        $this->middleware(['permission:qualifications_read'])->only('index');
        $this->middleware(['permission:qualifications_create'])->only('create');
        $this->middleware(['permission:qualifications_update'])->only('edit');
        $this->middleware(['permission:qualifications_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $qualifications = Qualification::OrderBy('created_at', 'desc')->get();
        return view('settings::qualifications.index', compact('qualifications'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::qualifications.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(QualificationRequest $request) {
        try {
            $data = $request->all();
            if($request->has('is_azhar')){
                $data['is_azhar'] = '1';
            }else{
               $data['is_azhar'] = '0';
            }
            $qualification = Qualification::create($data);
            if ($qualification) {
                notify()->success(__('data created successfully'), "", "bottomLeft");
                return redirect()->route('qualifications.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('qualifications.index');
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('qualifications.index');
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
    public function update(Request $request, $id) {
        try {
            $data = $request->all();
            if($request->has('is_azhar')){
                $data['is_azhar'] = '1';
            }else{
               $data['is_azhar'] = '0';
            }
            $qualification = Qualification::find($id);

            if (!$qualification) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('qualifications.index');
            } else {
                $qualification->update($data);
                notify()->success(__('data updated successfully'), "", "bottomLeft");
                return redirect()->route('qualifications.index');
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
            return redirect()->route('qualifications.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $setting = Qualification::find($id);
            if (!$setting) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            }

            $qualification_types = $setting->qualification_types();

            if (isset($qualification_types) && $qualification_types->count() > 0) {
                notify()->error(__('this item can not be deleted'), "", "bottomLeft");
            } else {
                $setting->delete();
                notify()->success(__('data deleted successsfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('qualifications.index');
    }

}
