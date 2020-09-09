<?php

namespace Modules\Military\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Military\Entities\MilitaryStatus;
use Modules\Military\Http\Requests\MilitaryStatusRequest;

class MilitaryStatusController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $militaryStatus = MilitaryStatus::OrderBy('created_at', 'desc')->get();
        return view('military::military_status.index', compact('militaryStatus'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('military::military_status.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MilitaryStatusRequest $request) {
        try {
            $status = MilitaryStatus ::create($request->all());

            notfy(__('add military status'), __('add military status'). $status->name, 'fa fa-circle-o');
            notify()->success("تم حفظ الاعدادات بنجاح", "", "bottomLeft" );
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft" );
           
        }
        return redirect()->route('military-status.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('military::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $militaryStatus = MilitaryStatus::find($id);
        if (!$militaryStatus) {
            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('military-status.index');
        }
        return view('military::military_status.edit', compact('militaryStatus'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MilitaryStatusRequest $request, $id) {
        try {
            $militaryStatus = MilitaryStatus::find($id);

            if (!$militaryStatus) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('military-status.index');
            } else {

                $militaryStatus->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
                return redirect()->route('military-status.index');
            }
        } catch (\Exception $th) {
            notify()->error( $th->getMessage(), "", "bottomLeft");
            return redirect()->route('military-status.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $militaryStatus = MilitaryStatus::find($id);

            if (!$militaryStatus) {
                notify()->warning(__('data not found'), "", "bottomLeft");
                return redirect()->route('military-status.index');
            }
            $militaryStatus->delete();
            notify()->success(__('data deleted successfully'), "", "bottomLeft");
            return redirect()->route('military-status.index');
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
            return redirect()->route('military-status.index');
        }
    }

}
