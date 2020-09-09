<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Store; 

class StoreController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:stores_read'])->only('index');
        $this->middleware(['permission:stores_create'])->only('create');
        $this->middleware(['permission:stores_update'])->only('edit');
        $this->middleware(['permission:stores_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Store::find(request()->resource_id);
        
        $query = Store::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::stores.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::stores.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all(); 
            $data['balance'] = $request->init_balance;
            $resource = Store::create($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add store'), __('add store') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('stores.index');
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
        $resource = Store::find($id);
        return view('account::stores.edit', compact('resource'));
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
            
            $resource = Store::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit store'), __('edit store') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('stores.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = Store::find($id);
            if ($resource->transformations()->count() > 0) {
                notify()->error(__('cant remove store has transformations'), "", "bottomLeft", "");
                return redirect()->route('stores.index');
            }
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove store'), __('remove store') . $resource->name, "fa fa-money");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('stores.index');
    }
}
