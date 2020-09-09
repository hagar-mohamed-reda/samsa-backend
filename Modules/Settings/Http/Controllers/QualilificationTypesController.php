<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\QualificationTypes;
use Modules\Settings\Http\Requests\QualificationTypeRequest;

class QualilificationTypesController extends Controller {

    public function __construct() {
        $this->middleware(['permission:qualification-types_read'])->only('index');
        $this->middleware(['permission:qualification-types_create'])->only('create');
        $this->middleware(['permission:qualification-types_update'])->only('edit');
        $this->middleware(['permission:qualification-types_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $query = QualificationTypes::query();

        if (request()->level_id > 0)
            $query->where('level_id', request()->level_id);

        if (request()->academic_year_id > 0)
            $query->where('academic_year_id', request()->academic_year_id);

        $qualification_types = $query->OrderBy('created_at', 'desc')->get();
        return view('settings::qualification_types.index', compact('qualification_types'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::qualification_types.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(QualificationTypeRequest $request) {
        try {
            $qualification_type = QualificationTypes::create($request->all());
            if ($qualification_type) {
                notify()->success(__('data created successfully'), "", "bottomLeft");
                return redirect()->route('qualification-types.index');
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
                return redirect()->route('qualification-types.index');
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('qualification-types.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $qualification = QualificationTypes::select()->find($id);
        if (!$qualification) {

            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('qualification-types.index');
        }

        return view('settings::qualification_types.edit', compact('qualification'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(QualificationTypeRequest $request, $id) {
        try {
            $qualification = QualificationTypes::find($id);

            if (!$qualification) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $qualification->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('qualification-types.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $setting = QualificationTypes::find($id);
            if (!$setting) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $setting->delete();
                notify()->success(__('data deleted successsfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('qualification-types.index');
    }

}
