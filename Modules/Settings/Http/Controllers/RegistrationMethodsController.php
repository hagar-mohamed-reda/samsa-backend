<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\RegistrationMethod;
use Modules\Settings\Http\Requests\RegisterationMethodsRequest;

class RegistrationMethodsController extends Controller {

    public function __construct() {
//        $this->middleware(['permission:registeration-methods_read'])->only('index');
//        $this->middleware(['permission:registeration-methods_create'])->only('create');
//        $this->middleware(['permission:registeration-methods_update'])->only('edit');
//        $this->middleware(['permission:registeration-methods_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $registerationMethods = RegistrationMethod::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $registerationMethods);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::registeration_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $validator = validator($request->all(), [
            "name" => "required",
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $registerationMethods = RegistrationMethod::create($request->all());
            if ($registerationMethods) {
                return responseJson(1, __('data created successfully'), $registerationMethods);
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "" );
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        $registerationMethods = RegistrationMethod::find($id);
        if (!$registerationMethods) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $registerationMethods);    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $registerationMethod = RegistrationMethod::find($id);
        if (!$registerationMethod) {
            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('registeration-methods.index');
        }
        return view('settings::registeration_methods.edit', compact('registerationMethod'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $validator = validator($request->all(), [
            "name" => "required",
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->getMessages(), "");
        }
        try {
            $registerationMethods = RegistrationMethod::find($id);
            if (!$registerationMethods) {
                return responseJson(0, __('data not found'), '');
            } else {

                $registerationMethods->update($request->all());

                return responseJson(1, __('data updated successfully'), $registerationMethods);
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
    public function destroy($id) {
        try {
            $registerationMethods = RegistrationMethod::find($id);
            if (!$registerationMethods) {
                return responseJson(0, __('data not found'), '');
            }
            if ($registerationMethods->applications->count() > 0 || $registerationMethods->students->count()  > 0 ) {
                return responseJson(0, __('this item can not be deleted'), $registerationMethods->fresh());
            }
            $registerationMethods->delete();
            return responseJson(1, __('deleted successfully'), '');
        } catch (\Exception $ex) {
            return responseJson(0, "", $ex->getMessage());
        }
    }

}
