<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryAreas;
use Modules\Military\Http\Requests\MilitaryAreaRequest;

class MilitaryAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $militarAreas = MilitaryAreas::with(['government'])->OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $militarAreas);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('military::military_areas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MilitaryAreaRequest $request)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            "government_id" => 'required|exists:governments,id'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }

        try {
            $militaryArea = MilitaryAreas::create($request->all());
            if ($militaryArea) {
                return responseJson(1, __('data created successfully'), $militaryArea);
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('military-areas.index');
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
        $militaryArea = MilitaryAreas::find($id);
        $militaryArea->government;
        $militaryArea->government->country;
        if (!$militaryArea) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $militaryArea);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $militaryArea = MilitaryAreas::find($id);
        if (!$militaryArea) {
            notify()->warning( __('data not found'), "", "bottomLeft");
            return redirect()->route('military-areas.index');
        }
        return view('military::military_areas.edit', compact('militaryArea'));
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
            "name" => "required",
            "government_id" => 'required|exists:governments,id'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $militaryArea = MilitaryAreas::find($id);
            if (!$militaryArea) {
                return responseJson(0, __('data not found'), '');
            } else {
                $militaryArea->update($request->all());
                return responseJson(1, __('data updated successfully'), $militaryArea);
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
        $militaryArea = MilitaryAreas::find($id);
        $coutAreas = $militaryArea->militaryAreaSubmission->count();
        try {
            if (!$militaryArea) {
                notify()->warning( __('data not found'), "", "bottomLeft");
                return redirect()->route('military-areas.index');
            }  if(isset($coutAreas) && $coutAreas > 0 ){
                notify()->error(__('this item can not be deleted'),"","bottomLeft");
                return redirect()->route('military-areas.index');
            }else{
                $militaryArea->delete();
                notify()->success( __('data deleted successsfully'),"","bottomLeft");
                return redirect()->route('military-areas.index');
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('military-areas.index');
        }
    }
}
