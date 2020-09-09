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
        $militarAreas = MilitaryAreas::OrderBy('created_at', 'desc')->get();
        return view('military::military_areas.index', compact('militarAreas'));
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
        try {
            $militaryArea = MilitaryAreas::create($request->all());
            if ($militaryArea) {
                notify()->success( __('data created successfully'), "", "bottomLeft");
                return redirect()->route('military-areas.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('military-areas.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('military-areas.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('military::show');
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
    public function update(MilitaryAreaRequest $request, MilitaryAreas $militaryArea)
    {
        try {
            if (!$militaryArea) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('military-areas.index');
            } else {
                $militaryArea->update($request->all());
                notify()->success( __('data updated successfully'), "", "bottomLeft");
                return redirect()->route('military-areas.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('military-areas.index');
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
