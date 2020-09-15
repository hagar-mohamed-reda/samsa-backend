<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CityRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['permission:cities_read'])->only('index');
//        $this->middleware(['permission:cities_create'])->only('create');
//        $this->middleware(['permission:cities_update'])->only('edit');
//        $this->middleware(['permission:cities_delete'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::with(['government'])->OrderBy('created_at', 'desc')->paginate(10);
        return responseJson(1, "ok", $cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('main_settings.cities.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $validator = validator($request->all(), [
            "name" => "required",
            "government_id" => 'required|exists:cities'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $city = City::create($request->all());
            if ($city) {
                return responseJson(1, __('data created successfully'), $city);

            } else {

            }

        } catch (Exception $th) {
            return responseJson(0, "", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $city = City::find($id);
        if (!$city) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $city = City::find($id);
        if (!$city) {
            return responseJson(0, __('data not found'), '');

        }
        return view('main_settings.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            "name" => "required",
            "government_id" => 'required|exists:cities'
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $city = City::find($id);
            if (!$city) {
                return responseJson(0, __('data not found'), '');
            } else {
                $city->update($request->all());
                return responseJson(1, __('data updated successfully'), $city);

            }
        } catch (Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $city = City::find($id);
            if (!$city) {
                return responseJson(0, __('data not found'), '');
            }

            if ($city->applications->count() > 0 || $city->students->count()  > 0 ) {
                return responseJson(0, __('this item can not be deleted'), $city->fresh());
            }
            $city->delete();
            return responseJson(1, __('deleted successfully'), '');

        } catch (Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }
}
