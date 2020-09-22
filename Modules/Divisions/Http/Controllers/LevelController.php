<?php

namespace Modules\Divisions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Divisions\Entities\Level;
use Modules\Divisions\Http\Requests\LevelRequest;

class LevelController extends Controller {

    public function __construct() {
        // $this->middleware(['permission:levels_read'])->only('index');
        // $this->middleware(['permission:levels_create'])->only('create');
        // $this->middleware(['permission:levels_update'])->only('edit');
        // $this->middleware(['permission:levels_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $levels = Level::OrderBy('created_at', 'desc')->get();
        return responseJson(1, "ok", $levels);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('divisions::levels.create');
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
            $level = Level::create($request->all());
            if ($level) {
                return responseJson(1, __('data created successfully'), $level);

            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('levels.index');
            }
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "");
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        $level = Level::find($id);
        if (!$level) {
            return responseJson(0, __('data not found'), '');
        }
        return responseJson(1, "ok", $level);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $level = Level::find($id);
        if (!$level) {
            notify()->warning( __('data not found'), "", "bottomLeft" );
            return redirect()->route('levels.index');
        }
        return view('divisions::levels.edit', compact('level'));
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
            $level = Level::find($id);
            if (!$level) {
                return responseJson(0, __('data not found'), '');
            } else {
                $level->update($request->all());
                return responseJson(1, __('data updated successfully'), $level);
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
            $level = Level::find($id);
            if (!$level) {
                return responseJson(0, __('data not found'), '');
            }
            $departments = $level->department->count();
            $applications = $level->applications->count();
            $students = $level->students->count();

            if($departments > 0 && $applications > 0 && $students > 0){
                return responseJson(0, __('this item can not be deleted'), $city->fresh());
            }
            $level->delete();
            return responseJson(1, __('deleted successfully'), '');
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage(), "");
        }
    }

}
