<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Transformation;
use Modules\Account\Entities\Bank;
use Modules\Account\Entities\Store;

class TransformationController extends Controller
{

    public function __construct() {
        /* $this->middleware(['permission:transformations_read'])->only('index');
          $this->middleware(['permission:transformations_create'])->only('create');
          $this->middleware(['permission:transformations_update'])->only('edit');
          $this->middleware(['permission:transformations_delete'])->only('destroy'); */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;

        if (request()->resource_id)
            $resource = Transformation::find(request()->resource_id);

        $query = Transformation::query();

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
        return view('account::transformations.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::transformations.create');
    }

    /**
     * Transformation a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            if ($request->type == "bank_to_store") {
                if ($request->value > Bank::find($request->bank_id)->balance) {
                    notify()->error(__('balance of bank not enough'), "", "bottomLeft", "");
                    return redirect()->route('transformations.index');
                }
            }
            if ($request->type == "store_to_bank") {
                if ($request->value > Store::find($request->store_id)->balance) {
                    notify()->error(__('balance of store not enough'), "", "bottomLeft", "");
                    return redirect()->route('transformations.index');
                }
            }

            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $resource = Transformation::create($data);

            $this->editValue($resource, $request->value, $request->type);
            // upload personal image 
            uploadImg($request->file('attachment'), "uploads/transformations", function($filename) use ($resource) {
                $resource->update([
                    'attachment' => "uploads/transformations" . "/" . $filename
                ]);
            });

            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add transformation'), __('add transformation') . $resource->code, "fa fa-transformation");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('transformations.index');
    }

    public function editValue(Transformation $resource, $value, $type) {
        if ($type == 'bank_to_store') {
            $resource->bank->balance -= $value;
            $resource->store->balance += $value;
        } else if ($type == 'store_to_bank') {
            $resource->store->balance -= $value;
            $resource->bank->balance += $value;
        }

        $resource->bank->update();
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
        $resource = Transformation::find($id);
        return view('account::transformations.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            if ($request->type == "bank_to_store") {
                if ($request->value > Bank::find($request->bank_id)->balance) {
                    notify()->error(__('balance of bank not enough'), "", "bottomLeft", "");
                    return redirect()->route('transformations.index');
                }
            }
            if ($request->type == "store_to_bank") {
                if ($request->value > Store::find($request->store_id)->balance) {
                    notify()->error(__('balance of store not enough'), "", "bottomLeft", "");
                    return redirect()->route('transformations.index');
                }
            }
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;

            $resource = Transformation::find($id);
            // reset value
            $this->editValue($resource, -1 * $resource->value, $resource->type);

            $resource->update($data);
            $this->editValue($resource, $request->value, $request->type);


            // upload attachment
            uploadImg($request->file('attachment'), "uploads/transformations", function($filename) use ($resource) {
                if (file_exists(public_path() . "/" . $resource->attachment)) {
                    unlink(public_path() . "/" . $resource->attachment);
                }

                $resource->update([
                    'attachment' => "uploads/transformations" . "/" . $filename
                ]);
            });

            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit transformation'), __('edit transformation') . $resource->code, "fa fa-transformation");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('transformations.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = Transformation::find($id);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove transformation'), __('remove transformation') . $resource->id, "fa fa-transformation");

            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('transformations.index');
    }
}
