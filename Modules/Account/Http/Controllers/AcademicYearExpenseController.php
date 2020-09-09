<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AcademicYearExpense; 
use Modules\Account\Entities\AcademicYearExpenseDetail; 

class AcademicYearExpenseController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = AcademicYearExpense::with(['academic_year', 'level', 'division', 'details'])->get();
        return responseJson(1, "", $resources);
    }
 
    /**
     * AcademicYearExpense a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function store(Request $request) {
        try {
            $validator = validator($request->all(), [ 
                "academic_year_id" =>  "required",
                "level_id" =>  "required",
                "division_id" =>  "required",
                "name" =>  "required",
                "priorty" =>  "required",
                "value" =>  "required", 
                "term_id" =>  "required", 
                "store_id" =>  "required", 
                "discount" =>  "required", 
            ]);
            
            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
            $data = $request->all();
            $resource = AcademicYearExpense::create($data); 
            
            // add details
            $data['academic_year_expense_id'] = $resource->id;
            $detail = AcademicYearExpenseDetail::create($data);
            
            log(__('add academic year expense ') . $detail->name, "fa fa-money");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'));
    }
  

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $detail = AcademicYearExpenseDetail::find($request->academic_year_expense_id);
            $detail->update($request->all()); 
            log(__('edit academic year expense ') . $detail->name, "fa fa-money");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) { 
        try {
            $detail = AcademicYearExpenseDetail::find($id); 
            log(__('remove academic year expense ') . $detail->name, "fa fa-money"); 
            $detail->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
