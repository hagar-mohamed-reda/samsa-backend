<?php

namespace App\Http\Controllers;

use App\Government;
use App\Http\Requests\GovernmentRequest;
use Illuminate\Http\Request;

class GovernmentController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['permission:governments_read'])->only('index');
//        $this->middleware(['permission:governments_create'])->only('create');
//        $this->middleware(['permission:governments_update'])->only('edit');
//        $this->middleware(['permission:governments_delete'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $governments = Government::OrderBy('created_at', 'desc')->paginate(10);
        return responseJson(1, "ok", $governments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.governments.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            "country_id" => 'required|exists:countries,id'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $government = Government::create($request->all());
            if ($government) {
                return responseJson(1, __('data created successfully'), $government);

            } else {

            }
        } catch (\Exception $th) {
            return responseJson(0, "", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $government = Government::find($id);
        if (!$government) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $government);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $government = Government::find($id);
        if (!$government) {

            notify()->warning("هذه الاعدادات غير موجودة !", "", "bottomLeft", );
            return redirect()->route('governments.index');
        }
        return view('main_settings.governments.edit', compact('government'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            "country_id" => 'required|exists:countries,id'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $government = Government::find($id);

            if (!$government) {
                return responseJson(0, __('data not found'), '');
            } else {
                $government->update($request->all());
                return responseJson(1, __('data updated successfully'), $government);
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $government = Government::find($id);
        $cities = $government->cities->count();
        try {
            if (!$government) {
                return responseJson(0, __('data not found'), '');
            }
            if (isset($cities) && $cities > 0 || $government->applications->count() > 0 || $government->students->count() > 0) {
                return responseJson(0, __('this item can not be deleted'), $government->fresh());
            } else {
                $government->delete();
                return responseJson(1, __('deleted successfully'), '');
            }

        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

    public function getGovernments($country_id)
    {
        return Government::where('country_id', $country_id)->pluck('id', 'name')->toArray();
    }
}
