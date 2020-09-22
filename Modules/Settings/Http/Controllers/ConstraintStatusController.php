<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ConstraintStatus;

class ConstraintStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $resources = ConstraintStatus::orderBy('created_at', 'DESC')->get();
        return responseJson(1, "ok", $resources);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::constraint_status.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }

        try {
            $resource = ConstraintStatus::create($request->all());
            if ($resource) {
                return responseJson(1, __('data created successfully'), $resource);
            }
        } catch (\Exception $th) {
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
        $resource = ConstraintStatus::find($id);
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
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('constraint-status.index');
            } else {
                return view('settings::case_constraint.edit', compact('resource'));
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('constraint-status.index');
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                return responseJson(0, __('data not found'), '');
            } else {
                $resource->update($request->all());
                return responseJson(1, __('data updated successfully'), $resource);
            }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "");
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
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                return responseJson(0, __('data not found'), '');
            } else {
                $resource->delete();
                return responseJson(1, __('deleted successfully'), '');
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }
    
}
