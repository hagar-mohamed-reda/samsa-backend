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
//        $this->middleware(['permission:registeration-status_read'])->only('index');
//        $this->middleware(['permission:registeration-status_create'])->only('create');
//        $this->middleware(['permission:registeration-status_update'])->only('edit');
//        $this->middleware(['permission:registeration-status_delete'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {  
        $data = RegisterationStatus::latest()->get();
        return $data; 
    }

    /**
     * update required document of registeration status
     * 
     * 
     */
    public function updateRequiredDocument(RegisterationStatus $resource, Request $request) {
        try {
            // remove old
            RegisterationStatusDocument::where('registeration_status_id', $resource->id)->delete();

            // add new
            foreach ($request->required_documents as $item) {
                RegisterationStatusDocument::create([
                    'registeration_status_id' => $resource->id,
                    'required_document_id' => $item
                ]);
            }

        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
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
             
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
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
            $registerationStatus->update($request->all()); 
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage());
        }
        return responseJson(1, __('done'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(RegisterationStatus $resource) {
        try { 
            if ($resource->can_delete)
                $resource->delete(); 
        } catch (\Exception $ex) {
            return responseJson(0, $ex->getMessage());
        }
        return responseJson(1, __('done'));
    }

}
