<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryStatusSetting;

class MilitaryStatusSettingController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $rows = MilitaryStatusSetting::orderBy('created_at', 'DESC')->get();
        return view('military::military_status_reason.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('military::military_status_reason.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {

//        dd($request->all());
        $request->validate([
            'condition_age' => 'required',
            'military_status_id' => 'required',
            'reason' => 'required',
        ]);
        try {
            $resource = MilitaryStatusSetting ::create($request->all());
            notfy(__('add military status settings'), __('add military status settings'), 'fa fa-circle-o');
            notify()->success(__('process has been success'), "", "bottomLeft");
            return redirect()->route('military-status-reason.index');
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-status-reason.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('military::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = MilitaryStatusSetting::find($id);
        if (!$resource) {
            notify()->warning(__('not found data'), "", "bottomLeft");
            return redirect()->route('military-area-submission.index');
        }
        return view('military::military_status_reason.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            'condition_age' => 'required',
            'military_status_id' => 'required',
            'reason' => 'required',
        ]);
        try {
            $resource = MilitaryStatusSetting::find($id);
            if (!$resource) {
                notify()->warning(__('not found data'), "", "bottomLeft");
            } else {
                $resource->update($request->all());
                notfy(__('military status settings updated'), __('military status settings updated '), 'fa fa-circle-o');
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-status-reason.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
            $resource = MilitaryStatusSetting::find($id);
        try {
            if (!$resource) {
                notify()->warning(__('not found data'), "", "bottomLeft");
            } else {
                $resource->delete();
                notify()->success(__('data deleted successfully'), "", "bottomLeft" );
                notfy(__('military status settings deleted'), __('military status settings deleted ') . $status->name, 'fa fa-building-o');
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-status-reason.index');
    }

}
