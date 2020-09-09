<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Plan; 
use Modules\Account\Entities\PlanDetail; 
use Modules\Account\Entities\ExpenseMainCategory;
use Modules\Account\Entities\PlanExpenseMainCategory;
use Modules\Account\Entities\PlanCaseConstraint;

class PlanController extends Controller
{

    public function __construct() {
        /*$this->middleware(['permission:plans_read'])->only('index');
        $this->middleware(['permission:plans_create'])->only('create');
        $this->middleware(['permission:plans_update'])->only('edit');
        $this->middleware(['permission:plans_delete'])->only('destroy'); */
    } 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        
        if (request()->resource_id)
            $resource = Plan::find(request()->resource_id);
        
        $query = Plan::query();
 
        $resources = $query->OrderBy('created_at', 'desc')->get();
        return view('account::plans.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $resource = new Plan();
        return view('account::plans.create', compact('resource'));
    }

    /**
     * Plan a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try { 
            $expenseMainCategory = ExpenseMainCategory::find($request->expense_maincategory_id);
            $sum = 0;
            foreach($request->values as $item) {
                $sum += $item;
            }
            
            if ($sum != $expenseMainCategory->value) {
                return responseJson(0, __('sum of values must equal ') . $expenseMainCategory->value);
            } 
            $data = $request->all(); 
            $data['value'] = $expenseMainCategory->value;
             
            // create plan
            $plan = Plan::create($data);
             
            // store datails
            for($index = 0; $index < count($request->date_from); $index ++) {
                $detail = PlanDetail::create([
                    "date_from" => $request->date_from[$index],
                    "date_to" => $request->date_to[$index],
                    "value" => $request->values[$index],
                    "fine_id" => $request->fine_id[$index],
                    "notes" => $request->noteses[$index],
                    "plan_id" => $plan->id
                ]);  
                // store expense main category
                $expenses = explode(",", $request->expense_maincategory_ids[$index]);
                foreach($expenses as $exp) {
                    PlanExpenseMainCategory::create([
                        "plan_detail_id" => $detail->id,
                        "expense_maincategory_id" => $exp,
                    ]);
                } 
            }
            
            // store case contains
            foreach($request->case_constraint_check as $item) {
                PlanCaseConstraint::create([
                    "plan_id" => $plan->id,
                    "case_constraint_id" => $item
                ]);
            }
              
            notfy(__('add plan'), __('add plan') . $plan->name, "fa fa-map-marker");
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
        $resource = Plan::find($id);
        return view('account::show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = Plan::find($id);
        return view('account::plans.edit', compact('resource'));
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
            
            $resource = Plan::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit plan'), __('edit plan') . $resource->code, "fa fa-plan");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", ""); 
        }
        
        return redirect()->route('plans.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        
        try {
            $resource = Plan::find($id);
            
            if ($resource->transformations()->count() > 0) {
                notify()->error(__('cant remove plan has transformations'), "", "bottomLeft", "");
                return redirect()->route('plans.index');
            }
            
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove plan'), __('remove plan') . $resource->name, "fa fa-plan");
            
            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft"); 
        }
        return redirect()->route('plans.index');
    }
}
