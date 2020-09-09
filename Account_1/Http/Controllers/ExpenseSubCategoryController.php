<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\ExpenseSubCategory; 
use Modules\Account\Entities\ExpenseMainCategory; 

class ExpenseSubCategoryController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:expense_subcategorys_read'])->only('index');
        $this->middleware(['permission:expense_subcategorys_create'])->only('create');
        $this->middleware(['permission:expense_subcategorys_update'])->only('edit');
        $this->middleware(['permission:expense_subcategorys_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = ExpenseMainCategory::find(request()->resource_id);
        
        $query = ExpenseSubCategory::query();
                //->where('expenses_maincategory_id', request()->expenses_maincategory_id);
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::expense_subcategorys.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::expense_subcategorys.create');
    }

    /**
     * ExpenseSubCategory a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {  
            $expenseMainCategory = ExpenseMainCategory::find($request->expenses_maincategory_id);
            // validate on sum
            $sum = 0;
            foreach($request->value as $value)
                $sum += $value;
             
            if ($sum != $expenseMainCategory->value)
                return responseJson(0, __('value of sum must be equal ') . " " . $expenseMainCategory->value);
            
            $expenseMainCategory->expenseSubCategories()->delete();
            for($index = 0; $index < count($request->name); $index ++) { 
                ExpenseSubCategory::create([
                    "name" => $request->name[$index],
                    "value" => $request->value[$index],
                    "priority" => $request->priority[$index],
                    "store_id" => $request->store_id[$index],
                    "notes" => $request->notes[$index],
                    "expenses_maincategory_id" => $expenseMainCategory->id,
                ]);
            } 
            notfy(__('add expense_subcategory'), __('add expense_subcategory'), "fa fa-list-o");
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
        $resource = ExpenseSubCategory::find($id);
        return view('account::expense_subcategorys.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $expenseMainCategory = ExpenseMainCategory::find($request->expenses_maincategory_id);
            // validate on sum
            $sum = 0;
            foreach($request->value as $value)
                $sum += $value;
            
            if ($sum != $expenseMainCategory->value)
                return responseJson(0, __('value of sum must be equal ') . " " . $expenseMainCategory->value);
             
            for($index = 0; $index < count($request->id); $index ++) { 
                $id = $request->id[$index];
                
                $expenseSubCategory = ExpenseSubCategory::find($id);
                
                if (!$expenseSubCategory) {
                    ExpenseSubCategory::create([
                        "name" => $request->name[$index],
                        "value" => $request->value[$index],
                        "priority" => $request->priority[$index],
                        "store_id" => $request->store_id[$index],
                        "notes" => $request->notes[$index],
                        "expenses_maincategory_id" => $expenseMainCategory->id,
                    ]);
                } else {
                    $expenseSubCategory->update([
                        "name" => $request->name[$index],
                        "value" => $request->value[$index],
                        "priority" => $request->priority[$index],
                        "store_id" => $request->store_id[$index],
                        "notes" => $request->notes[$index], 
                    ]);
                }
                
                
            } 
            notfy(__('add expense_subcategory'), __('add expense_subcategory'), "fa fa-list-o");
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
            $resource = ExpenseSubCategory::find($id);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove expense_maincategory'), __('remove expense_maincategory') . $resource->name, "fa fa-list-o");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('expense_subcategorys.index');
    }
}
