<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryCourse;

class MilitaryCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $rows = MilitaryCourse::orderBy('created_at', 'DESC')->get();
        return view('military::military_course.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('military::military_course.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {

            $row = MilitaryCourse::create($request->all());

            notfy(__('add military course'), __('add military course'), "fa fa-map-marker");
            notify()->success(__('process has been success'), "", "bottomLeft");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course.index');
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
        $row = MilitaryCourse::find($id);
        if (!$row) {
            notify()->warning(__('These settings do not exist'), "", "bottomLeft");
            return redirect()->route('military-course.index');
        }
        return view('military::military_course.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {

            $row = MilitaryCourse::find($id);
            if (!$row) {
                notify()->warning(__('These settings do not exist'), "", "bottomLeft");
            } else {
                $row->update($request->all());
                notfy(__('military course updated'), __('military course updated') . $row->name, 'fa fa-cog');
                notify()->success(__('The data has been modified successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course.index');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $row = MilitaryCourse::find($id);
        $militaryCollections = $row->collections->count();

        try {
            if (!$row) {
                notify()->warning(__('These settings do not exist'), "", "bottomLeft");
            }
            if (isset($militaryCollections) && $militaryCollections > 0) {
                notify()->error(__('This item cannot be deleted'), "", "bottomLeft");
            } else {
                $row->delete();
                notify()->success(__('deleted successfully'), "", "bottomLeft");
                notfy(__('military course deleted'), __('military course deleted') . $row->name, 'fa fa-cog');

            }

        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('military-course.index');
    }
}
