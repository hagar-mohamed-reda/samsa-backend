<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryAreaSubmision;
use Modules\Military\Http\Requests\MilitaryAreaSubmisionRequest;

class MilitaryAreaSubmisionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $rows = MilitaryAreaSubmision::orderBy('created_at', 'DESC')->get();
        return view('military::military_submission.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('military::military_submission.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MilitaryAreaSubmisionRequest $request)
    {
        try {

            $validatedData = $request->validate([
                'military_area_id' => 'required',
                'government_id' => 'required',
                'city_id' => 'required',
            ]);

            foreach ($request->city_id as $city) {
                $status = MilitaryAreaSubmision::create([
                    "military_area_id" => $request->military_area_id,
                    "government_id" => $request->government_id,
                    "city_id" => $city,
                    "notes" => $request->notes,
                ]);
            }

            notfy(__('add military area submission'), __('add military area submission'), "fa fa-map-marker");
            notify()->success(__('process has been success'), "", "bottomLeft");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-area-submission.index');
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
        $status = MilitaryAreaSubmision::find($id);
        if (!$status) {
            notify()->warning( __('data not found'), "", "bottomLeft");
            return redirect()->route('military-area-submission.index');
        }
        return view('military::military_submission.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MilitaryAreaSubmisionRequest $request, $id)
    {
        try {
            $status = MilitaryAreaSubmision::find($id);
            if (!$status) {
                notify()->warning( __('data not found'), "", "bottomLeft" );
                return redirect()->route('military-area-submission.index');
            } else {
                $status->update($request->all());
                notfy(__('military area updated'), __('military area updated ') . $status->name, 'fa fa-building-o');
                notify()->success(  __('data updated successfully'), "", "bottomLeft");
                return redirect()->route('military-area-submission.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('military-area-submission.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $status = MilitaryAreaSubmision::find($id);
        try {
            if (!$status) {
                notify()->warning( __('data not found'), "", "bottomLeft" );
                return redirect()->route('military-area-submission.index');
            } else {
                $status->delete();
                notify()->success(__('data deleted successfully'), "", "bottomLeft");
                notfy(__('military area deleted'), __('military area deleted ') . $status->name, 'fa fa-building-o');
                return redirect()->route('military-area-submission.index');
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('military-area-submission.index');
        }
    }
}
