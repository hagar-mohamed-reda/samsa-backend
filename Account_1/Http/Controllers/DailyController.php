<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Daily;
use Modules\Account\Entities\Store;

class DailyController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:dailys_read'])->only('index');
        $this->middleware(['permission:dailys_create'])->only('create');
        $this->middleware(['permission:dailys_update'])->only('edit');
        $this->middleware(['permission:dailys_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Daily::find(request()->resource_id);
        
        $query = Daily::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::dailys.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::dailys.create');
    }

    /**
     * Daily a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all(); 
            $data['user_id'] = Auth::user()->id;
            $store = Store::find($request->store_id);
            
            if ($request->value > $store->balance && $request->type == 'out') {
                    notify()->error(__('balance of store not enough'), "", "bottomLeft", "");
                    return redirect()->route('dailys.index');
            }
            
            $resource = Daily::create($data);
            // decrease value from store
            if ($resource->store && $request->type == 'out') {
                $resource->store->balance -= $data['value'];
                $resource->store->update();
            }
            if ($resource->store && $request->type == 'in') {
                $resource->store->balance += $data['value'];
                $resource->store->update();
            }
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add daily'), __('add daily') . $resource->code, "fa fa-daily");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('dailys.index');
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
        $resource = Daily::find($id);
        return view('account::dailys.edit', compact('resource'));
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
            
            $resource = Daily::find($id);
            // decrease value from store
            if ($resource->store && $request->type == 'out') {
                $resource->store->balance += $resource->value;
                $resource->store->update();
            }
            if ($resource->store && $request->type == 'in') {
                $resource->store->balance -= $resource->value;
                $resource->store->update();
            }
            $resource->update($data);
            // decrease value from store
            if ($resource->store && $request->type == 'out') {
                $resource->store->balance -= $data['value'];
                $resource->store->update();
            }
            if ($resource->store && $request->type == 'in') {
                $resource->store->balance += $data['value'];
                $resource->store->update();
            }
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit daily'), __('edit daily') . $resource->code, "fa fa-daily");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('dailys.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) { 
        try {
            $resource = Daily::find($id);
             
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove daily'), __('remove daily') . $resource->name, "fa fa-daily");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('dailys.index');
    }
}
