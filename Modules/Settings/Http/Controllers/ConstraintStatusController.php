<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ConstraintStatus;

class ConstraintStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $resources = ConstraintStatus::orderBy('created_at', 'DESC')->get();
        return view('settings::constraint_status.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::constraint_status.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required'
        ]);

        try {
            $resource = ConstraintStatus::create($request->all());
            if ($resource) {
                notfy(__('add constraint status'), __('add constraint status'), "fa fa-language");
                notify()->success(__('data creadted successfully'), "", "bottomLeft");
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('constraint-status.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
         try {
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('constraint-status.index');
            } else {
                return view('settings::case_constraint.edit', compact('resource'));
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
            return redirect()->route('constraint-status.index');
        }
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
            'name' => 'required'
        ]);
        try {
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $resource->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('constraint-status.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
          try {
            $resource = ConstraintStatus::find($id);
            if (!$resource) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $resource->delete();
                notify()->success(__('data has been deleted successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error( $ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('constraint-status.index');
    }
    
}
