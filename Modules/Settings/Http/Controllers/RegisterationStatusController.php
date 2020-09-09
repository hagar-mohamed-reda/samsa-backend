<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\RegisterationStatus;
use Modules\Settings\Http\Requests\RegisterationStatusRequest;
use Modules\Adminsion\Entities\RegisterationStatusDocument;

class RegisterationStatusController extends Controller {

    public function __construct() {
        $this->middleware(['permission:registeration-status_read'])->only('index');
        $this->middleware(['permission:registeration-status_create'])->only('create');
        $this->middleware(['permission:registeration-status_update'])->only('edit');
        $this->middleware(['permission:registeration-status_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $registerationStatus = null;

        if (request()->registeration_status_id > 0)
            $registerationStatus = RegisterationStatus::find(request()->registeration_status_id);

        $registerationStatuses = RegisterationStatus::OrderBy('created_at', 'desc')->get();
        return view('settings::registeration_status.index', compact('registerationStatuses', 'registerationStatus'));
    }

    /**
     * update required document of registeration status
     * 
     * 
     */
    public function updateRequiredDocument(RegisterationStatus $registerationStatus, Request $request) {
        try {
            // remove old
            RegisterationStatusDocument::where('registeration_status_id', $registerationStatus->id)->delete();

            // add new
            foreach ($request->required_document_check as $item) {
                RegisterationStatusDocument::create([
                    'registeration_status_id' => $registerationStatus->id,
                    'required_document_id' => $item
                ]);
            }

            notify()->success(__('process has been success'), "", "bottomLeft");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('registeration-status.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('settings::registeration_status.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(RegisterationStatusRequest $request) {
        try {
            $registerationStatus = RegisterationStatus::create($request->all());
            if ($registerationStatus) {
                notify()->success(__('data created successfully'), "", "bottomLeft");
            } else {
                notify()->error("هناك خطأ ما يرجى المحاولة فى وقت لاحق", "", "bottomLeft");
            }
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('registeration-status.index');
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
        $registerationStatus = RegisterationStatus::find($id);
        if (!$registerationStatus) {
            notify()->warning(__('data not found'), "", "bottomLeft");
            return redirect()->route('registeration-status.index');
        }
        return view('settings::registeration_status.edit', compact('registerationStatus'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(RegisterationStatusRequest $request, $id) {
        try {
            $registerationStatus = RegisterationStatus::find($id);
            if (!$registerationStatus) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            } else {
                $registerationStatus->update($request->all());
                notify()->success(__('data updated successfully'), "", "bottomLeft");
            }
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('registeration-status.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $registerationStatus = RegisterationStatus::find($id);
            if (!$registerationStatus) {
                notify()->warning(__('data not found'), "", "bottomLeft");
            }
            $registerationStatus->delete();
            notify()->success(__('data deleted successsfully'), "", "bottomLeft");
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('registeration-status.index');
    }

}
