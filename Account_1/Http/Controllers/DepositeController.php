<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Deposite;
use Modules\Account\Entities\Bank;
use Modules\Account\Entities\Store;

class DepositeController extends Controller
{

    public function __construct() {
        /* $this->middleware(['permission:deposites_read'])->only('index');
          $this->middleware(['permission:deposites_create'])->only('create');
          $this->middleware(['permission:deposites_update'])->only('edit');
          $this->middleware(['permission:deposites_delete'])->only('destroy'); */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;

        if (request()->resource_id)
            $resource = Deposite::find(request()->resource_id);

        $query = Deposite::query();

        if (request()->user_id > 0)
            $query->where('user_id', request()->user_id);

        if (request()->bank_id > 0)
            $query->where('bank_id', request()->bank_id);

        if (request()->store_id > 0)
            $query->where('store_id', request()->bank_id);

        if (request()->type)
            $query->where('type', request()->type);

        if (request()->date_from && request()->date_to)
            $query->whereBetween('date', [request()->date_from, request()->date_to]);

        $resources = $query->OrderBy('created_at', 'desc')->paginate(10);
        return view('account::deposites.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::deposites.create');
    }

    /**
     * Deposite a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {

        try {  
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['confirm'] = '0';
            $resource = Deposite::create($data);

            $this->editValue($resource, $request->value, $request->type);
            // upload personal image 
            uploadImg($request->file('attachment'), "uploads/deposites", function($filename) use ($resource) {
                $resource->update([
                    'attachment' => "uploads/deposites" . "/" . $filename
                ]);
            });

            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add deposite'), __('add deposite') . $resource->code, "fa fa-handshake-o");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('deposites.index');
    }

    public function editValue(Deposite $resource, $value, $type) {
        if ($type == 'bank') {
            if ($resource->bank)
                $resource->bank->balance += $value;
        } else if ($type == 'store') {
            if ($resource->store)
                $resource->store->balance += $value;
        }
        
        if ($resource->bank)
            $resource->bank->update();
        
        if ($resource->store)
            $resource->store->update();
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
        $resource = Deposite::find($id);
        return view('account::deposites.edit', compact('resource'));
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
            $data['user_id'] = Auth::user()->id;
            $data['confirm'] = '0';

            $resource = Deposite::find($id);
            // reset value
            $this->editValue($resource, -1 * $resource->value, $resource->type);

            $resource->update($data);
            $this->editValue($resource, $request->value, $request->type);


            // upload attachment
            uploadImg($request->file('attachment'), "uploads/deposites", function($filename) use ($resource) {
                if (file_exists(public_path() . "/" . $resource->attachment)) {
                    unlink(public_path() . "/" . $resource->attachment);
                }

                $resource->update([
                    'attachment' => "uploads/deposites" . "/" . $filename
                ]);
            });

            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit deposite'), __('edit deposite') . $resource->code, "fa fa-handshake-o");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('deposites.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = Deposite::find($id);
            $this->editValue($resource, -1 * $resource->value, $resource->type);
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove deposite'), __('remove deposite') . $resource->id, "fa fa-handshake-o");
 
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('deposites.index');
    }
}
