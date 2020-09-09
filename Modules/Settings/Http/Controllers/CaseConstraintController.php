<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\CaseConstraint;

class CaseConstraintController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resources = CaseConstraint::orderBy('created_at', 'DESC')->get();
        return view('settings::case_constraint.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::case_constraint.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $resource = CaseConstraint::create($request->all());
            if ($resource) {
                notfy(__('add case constraint'), __('add case constraint'), "fa fa-language");
                notify()->success(__('data creadted successfully'), "", "bottomLeft");
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('case-constraint.index');
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
            $resource = CaseConstraint::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('case-constraint.index');
            } else {
                return view('settings::case_constraint.edit', compact('resource'));
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('case-constraint.index');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required'
        ]);
        try {
            $resource = CaseConstraint::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $resource->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('case-constraint.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = CaseConstraint::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $resource->delete();
                notify()->success(__('data has been deleted successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('case-constraint.index');
    }

}
