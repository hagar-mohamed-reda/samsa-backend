<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ParentJobs;

class ParentJobsController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:parent-jobs_read'])->only('index');
//        $this->middleware(['permission:parent-jobs_create'])->only('create');
//        $this->middleware(['permission:parent-jobs_update'])->only('edit');
//        $this->middleware(['permission:parent-jobs_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $parent_jobs = ParentJobs::OrderBy('created_at', 'desc')->paginate(10);
        return responseJson(1, "ok", $parent_jobs);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::parent_jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|unique:parent_jobs,name',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $parent_jobs = ParentJobs::create($request->all());
            if ($parent_jobs) {
                watch(_('parent jobs year was created'), $icon = 'fa fa-accusoft');
                return responseJson(1, __('data created successfully'), $parent_jobs);
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('parent-jobs.index');
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
        $parent_jobs = ParentJobs::find($id);
        if (!$parent_jobs) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $parent_jobs);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $parent_jobs = ParentJobs::find($id);
            if (!$parent_jobs) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('parent-jobs.index');
            } else {
                return view('settings::parent_jobs.edit', compact('parent_jobs'));
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
            return redirect()->route('parent-jobs.index');
        }
        return view('settings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $parent_jobs = ParentJobs::find($id);
            if (!$parent_jobs) {
                return responseJson(0, __('data not found'), '');
            } else {
                $parent_jobs->update($request->all());
                return responseJson(1, __('data updated successfully'), $parent_jobs);
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
            $parent_jobs = ParentJobs::find($id);
            if (!$parent_jobs) {
                return responseJson(0, __('data not found'), '');
            } else {

                if ($parent_jobs->applications->count() > 0 || $parent_jobs->students->count() > 0) {
                    return responseJson(0, __('this item can not be deleted'), $parent_jobs->fresh());
                }
                $parent_jobs->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

}
