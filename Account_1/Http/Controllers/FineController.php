<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Fine; 

class FineController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:fines_read'])->only('index');
        $this->middleware(['permission:fines_create'])->only('create');
        $this->middleware(['permission:fines_update'])->only('edit');
        $this->middleware(['permission:fines_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Fine::find(request()->resource_id);
        
        $query = Fine::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::fines.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::fines.create');
    }

    /**
     * Fine a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all();  
            $resource = Fine::create($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add fine'), __('add fine') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('fines.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = Fine::find($id);
        return view('account::fines.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $data = $request->all(); 
            
            $resource = Fine::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit fine'), __('edit fine') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('fines.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        
        try {
            $resource = Fine::find($id);
            
            if ($resource->planDetail) {
                notify()->error(__('cant remove fine in plan'), "", "bottomLeft", "");
                return redirect()->route('fines.index');
            }
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove fine'), __('remove fine') . $resource->name, "fa fa-money");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('fines.index');
    }
}
