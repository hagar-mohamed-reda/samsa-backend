<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ParentJobs;

class ParentJobsController extends Controller {

    public function __construct() {
        $this->middleware(['permission:parent-jobs_read'])->only('index');
        $this->middleware(['permission:parent-jobs_create'])->only('create');
        $this->middleware(['permission:parent-jobs_update'])->only('edit');
        $this->middleware(['permission:parent-jobs_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $parent_jobs = ParentJobs::OrderBy('created_at', 'desc')->get();
        return view('settings::parent_jobs.index', compact('parent_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::parent_jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $parent_jobs = ParentJobs::create($request->all());
            if ($parent_jobs) {
                notify()->success(__('data created successfully'), "", "bottomLeft");
                return redirect()->route('parent-jobs.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('parent-jobs.index');
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('parent-jobs.index');
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
    public function update(Request $request, $id) {
        try {
            $parent_jobs = ParentJobs::find($id);
            if (!$parent_jobs) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $parent_jobs->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('parent-jobs.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $parent_jobs = ParentJobs::find($id);
            if (!$parent_jobs) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {

                $parent_jobs->delete();
                notify()->success(__('data deleted successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error(" هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
        }
        return redirect()->route('parent-jobs.index');
    }

}
