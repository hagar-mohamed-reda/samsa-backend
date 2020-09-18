<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{

    public function __construct()
    {
//        $this->middleware(['permission:countries_read'])->only('index');
//        $this->middleware(['permission:countries_create'])->only('create');
//        $this->middleware(['permission:countries_update'])->only('edit');
//        $this->middleware(['permission:countries_delete'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('main_settings.countries.create');
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
            "name" => "required|unique:countries,name",
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $country = Country::create($request->all());
            if($country){
                return responseJson(1, __('data created successfully'), $country);
            }else{
            }
        } catch (\Throwable $th) {
            return responseJson(0, "", $th->getMessage());


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $country);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        if (!$country) {
            notify()->error("هذه الاعدادات غير موجودة !","","bottomLeft",);
            return redirect()->route('countries.index');
        }
        return view('main_settings.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        $validator = validator($request->all(), [
            "name" => "required",
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $country = Country::find($id);
            if (!$country) {
                return responseJson(0, __('data not found'), '');

            } else {
                $country->update($request->all());
                return responseJson(1, __('data updated successfully'), $country);
            }
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $country = Country::find($id);
            if (!$country) {
                return responseJson(0, __('data not found'), '');
            }
            $governments = $country->governments->count();
            if(isset($governments) && $governments > 0 ||$country->applications->count() > 0 || $country->students->count()  > 0 ){
                return responseJson(0, __('this item can not be deleted'), $country->fresh());
            }else{
                $country->delete();
                return responseJson(1, __('deleted successfully'), '');
            }

        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }

    }
}
