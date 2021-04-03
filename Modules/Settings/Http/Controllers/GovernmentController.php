<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Settings\Entities\Government;

class GovernmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Government::latest()->get();

        return $query;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|unique:countries,name,".$request->id,
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), "");
        }
        try {
            $resource = Government::create($request->all());
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Government $resource)
    {
        $validator = validator($request->all(), [
            "name" => "required|unique:countries,name,".$request->id,
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), "");
        }
        try {
            $resource->update($request->all());
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Government $resource)
    {
        try {
                $resource->delete();
            return responseJson(1, __('done'));
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

    }
}
