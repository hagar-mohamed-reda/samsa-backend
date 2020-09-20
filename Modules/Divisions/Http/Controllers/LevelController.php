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
    public function store(LevelRequest $request) {
        try {
            $level = Level::create($request->all());
            if ($level) {
                notify()->success( __('data created successfully'), "", "bottomLeft");
                return redirect()->route('levels.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('levels.index');
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('levels.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('divisions::show');
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
    public function update(LevelRequest $request, $id) {
        try {
            $level = Level::find($id);
            if (!$level) {
                notify()->warning( __('data not found'), "", "bottomLeft");
                return redirect()->route('levels.index');
            } else {

                $level->update($request->all());
                notify()->success(  __('data updated successfully'), "", "bottomLeft");
                return redirect()->route('levels.index');
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
            return redirect()->route('levels.index');
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
            $departments = $level->department->count();

            if (!$level) {
                notify()->warning( __('data not found'), "", "bottomLeft");
            }

            if(isset($departments) && $departments > 0){
                 notify()->error(__('this item can not be deleted'), "", "bottomLeft");
                return redirect()->route('levels.index');
            }
            $level->delete();
            notify()->success( __('data deleted successfully'), "", "bottomLeft");
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('levels.index');
    }

}
