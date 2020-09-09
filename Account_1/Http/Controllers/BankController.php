<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bank; 

class BankController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:banks_read'])->only('index');
        $this->middleware(['permission:banks_create'])->only('create');
        $this->middleware(['permission:banks_update'])->only('edit');
        $this->middleware(['permission:banks_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Bank::find(request()->resource_id);
        
        $query = Bank::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::banks.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::banks.create');
    }

    /**
     * Bank a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all(); 
            $data['balance'] = $request->init_balance;
            $resource = Bank::create($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add bank'), __('add bank') . $resource->code, "fa fa-bank");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('banks.index');
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
        $resource = Bank::find($id);
        return view('account::banks.edit', compact('resource'));
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
            
            $resource = Bank::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit bank'), __('edit bank') . $resource->code, "fa fa-bank");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('banks.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        
        try {
            $resource = Bank::find($id);
            
            if ($resource->transformations()->count() > 0) {
                notify()->error(__('cant remove bank has transformations'), "", "bottomLeft", "");
                return redirect()->route('banks.index');
            }
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove bank'), __('remove bank') . $resource->name, "fa fa-bank");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('banks.index');
    }
}
