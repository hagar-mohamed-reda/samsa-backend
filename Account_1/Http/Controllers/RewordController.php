<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Reword; 

class RewordController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:rewords_read'])->only('index');
        $this->middleware(['permission:rewords_create'])->only('create');
        $this->middleware(['permission:rewords_update'])->only('edit');
        $this->middleware(['permission:rewords_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Reword::find(request()->resource_id);
        
        $query = Reword::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::rewords.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::rewords.create');
    }

    /**
     * Reword a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all();  
            $resource = Reword::create($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add reword'), __('add reword') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('rewords.index');
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
        $resource = Reword::find($id);
        return view('account::rewords.edit', compact('resource'));
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
            
            $resource = Reword::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit reword'), __('edit reword') . $resource->code, "fa fa-money");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('rewords.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        
        try {
            $resource = Reword::find($id);
            
            if ($resource->canDelete()) {
                notify()->error(__('cant remove reword in plan'), "", "bottomLeft", "");
                return redirect()->route('rewords.index');
            }
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove reword'), __('remove reword') . $resource->name, "fa fa-money");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('rewords.index');
    }
}
