<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Installment;
use Modules\Account\Entities\Student;

class InstallmentController extends Controller
{

    public function __construct() {
        // permission
    }

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = Installment::get();
        return responseJson(1, "", $resources);
    }

    /**
     * validate if the sum of installment equel to student balance
     * 
     * @param type $data
     */
    public function validateOnInstallmentSum($data, Student $student) {
        // init installments sum
        $installmentSum = 0;
        
        foreach ($data['data'] as $item) {
            if ($item['paid'] != 1)
                $installmentSum += $item['value'];
        }
        
        if ($data['type'] == "old") {
            if ($student->getStudentBalance()->getOldBalance() != $installmentSum) 
                return false;
        }
        
        if ($data['type'] == "new") {
            if ($student->getStudentBalance()->getCurrentBalance() != $installmentSum) 
                return false;
        }
        
        return true; 
    }

    /**
     * Installment a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            // retrieve all json data
            $data = $request->all();

            // get student object
            $student = Student::find($data['student_id']);
            
            // balance of student
            $balance = ($data['type'] == 'old')? $student->getStudentBalance()->getOldBalance() : $student->getStudentBalance()->getCurrentBalance();
                
            // check if balance >= 0
            if ($balance <= 0) 
                return responseJson(0, __('cant install balance 0'));
             
            // check on installment sum
            if (!$this->validateOnInstallmentSum($data, $student)) {
                return responseJson(0, __('sum of installments must equal ') . $balance);
            }
            
            // store or update installments in db
            foreach ($data['data'] as $item) { 
                $item['student_id'] = $student->id;
                $item['type'] = $data['type'];
                
                $installment = null;
                if (isset($item['id']) && $item['paid'] != 1) {
                    $installment = Installment::find($item['id']);
                    $installment->update($item);
                } else {
                    $installment = Installment::create($item);
                }
            }
  
            //log(__('install the balance of student') . $student->name, "fa fa-calendar");
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
            $resource = Installment::find($id);
            $resource->update($request->all());
            log(__('edit installment number ') . $resource->id, "fa fa-calendar");
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
            $resource = Installment::find($id);
            log(__('remove installment ') . $resource->name, "fa fa-calendar");
            $resource->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
