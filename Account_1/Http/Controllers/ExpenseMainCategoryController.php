<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\ExpenseMainCategory; 

class ExpenseMainCategoryController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:expense_maincategorys_read'])->only('index');
        $this->middleware(['permission:expense_maincategorys_create'])->only('create');
        $this->middleware(['permission:expense_maincategorys_update'])->only('edit');
        $this->middleware(['permission:expense_maincategorys_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = ExpenseMainCategory::find(request()->resource_id);
        
        $query = ExpenseMainCategory::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::expense_maincategorys.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::expense_maincategorys.create');
    }
    
    /**
     * validate on priorty 
     * 
     * @param $id
     */
    /*public function validateOnPriority(ExpenseMainCategory $resource = null) {
        Expense
    }*/

    /**
     * ExpenseMainCategory a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $validator = validator()->make($request->all(), [
            "priority" => "unique:account_expenses_maincategories"
        ], [
            "priority.unique" => __('priority already exist')
        ]);
        
        if ($validator->fails()) { 
            return responseJson(0, $validator->errors()->first()); 
        }
        try {
            $data = $request->all();  
            $resource = ExpenseMainCategory::create($data); 
            notfy(__('add expense_maincategory'), __('add expense_maincategory') . $resource->code, "fa fa-list-o");
        } catch (\Exception $th) { 
            return responseJson(0, $th->getMessage()); 
        }
        
        return responseJson(1, __('process has been success')); 
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
        $resource = ExpenseMainCategory::find($id);
        return view('account::expense_maincategorys.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $validator = validator()->make($request->all(), [
            "priority" => "unique:account_expenses_maincategories,priority,".$id
            ], [
                "priority.unique" => __('priority already exist')
            ]);

            if ($validator->fails()) { 
                return responseJson(0, $validator->errors()->first()); 
            }
            $data = $request->all();  
            
            $resource = ExpenseMainCategory::find($id);
            $resource->update($data); 
            notfy(__('edit expense_maincategory'), __('edit expense_maincategory') . $resource->code, "fa fa-list-o");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage()); 
        }
        
        return responseJson(1, __('process has been success')); 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = ExpenseMainCategory::find($id);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove expense_maincategory'), __('remove expense_maincategory') . $resource->name, "fa fa-list-o");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('expense_maincategorys.index');
    }
}
