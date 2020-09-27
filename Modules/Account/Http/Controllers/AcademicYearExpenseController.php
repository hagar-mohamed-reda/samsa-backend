<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AcademicYearExpense; 
use Modules\Account\Entities\AcademicYearExpenseDetail;
use Modules\Account\Entities\AccountSetting;

class AcademicYearExpenseController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index(Request $request) {
        $academicYear = AccountSetting::getCurrentAcademicYear();
        $resources = AcademicYearExpense::with(['academic_year', 'level', 'division', 'details'])
                ->where('academic_year_id', $academicYear->id)
                ->where('level_id', $request->level_id)
                ->where('division_id', $request->division_id)
                ->first();

        if (!$resources) {
            $resources = AcademicYearExpense::create([
                "level_id" => $request->level_id,
                "division_id" => $request->division_id,
                "academic_year_id" => $academicYear->id,
            ]);
        }
        return $resources;
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
            $resource = AcademicYearExpense::query()
                    ->where('academic_year_id', $data['academic_year_id'])
                    ->where('level_id', $data['level_id'])
                    ->where('division_id', $data['division_id'])
                    ->first();
            
            if (!$resource)
                $resource = AcademicYearExpense::create($data); 
            
            // add details
            $data['academic_year_expense_id'] = $resource->id;
            $detail = AcademicYearExpenseDetail::create($data);
            
            watch(__('add academic year expense ') . $detail->name, "fa fa-money");
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
    public function update(Request $request) {
        try {   

            foreach($request->details as $item) {
                $detail = isset($item['id'])? AcademicYearExpenseDetail::find($item['id']) : null;

                if ($detail) {
                    $detail->update($item);
                } else {
                    if (
                        isset($item['name']) && 
                        isset($item['priorty']) &&
                        isset($item['term_id']) &&
                        isset($item['value'])  
                    ) {
                        $data = $item; 
                        $data['store_id'] = 1;
                        $detail = AcademicYearExpenseDetail::create($data);
                    }
                }
            }
 
            watch(__('edit academic year expense '), "fa fa-money");
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
    public function destroy(AcademicYearExpenseDetail $resource) { 
        if (!$resource->canDelete())
            return responseJson(1, __('cant delete this academic year expense'));
        try { 
            watch(__('remove academic year expense ') . $resource->name, "fa fa-money"); 
            $resource->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
