<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\CaseConstraint;

class CaseConstraintController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $resources = CaseConstraint::orderBy('created_at', 'DESC')->get();
        return responseJson(1, "ok", $resources);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::case_constraint.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|unique:case_constraints,name'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }

        try {
            $resource = CaseConstraint::create($request->all());
            if ($resource) {
                watch(_('Case Constraint year was created'), $icon = 'fa fa-accusoft');
                return responseJson(1, __('data created successfully'), $resource);
            }
        } catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(),"");
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $resource = CaseConstraint::find($id);
        if (!$resource) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $resource);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

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
    public function update(Request $request, $id)
    {
        $resource = CaseConstraint::find($id);
        if (!$resource) {
            return responseJson(0, __('data not found'), '');
        }
        $validator = validator($request->all(), [
            'name' => 'required|unique:case_constraints,id,'.$resource->id
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }

        try {
            $resource->update($request->all());
            return responseJson(1, __('data updated successfully'), $resource);

        } catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(),"");
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
            $resource = CaseConstraint::find($id);
            if (!$resource) {
                return responseJson(0, __('data not found'), '');
            } else {
                $resource->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0,  $ex->getMessage(),"");
        }
    }

}
