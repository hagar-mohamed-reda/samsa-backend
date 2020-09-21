<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Installment;
use Modules\Account\Entities\Student;
use Modules\Account\Entities\AccountSetting;

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
        $query = Installment::query();
        
        if (request()->student_id) {
            $query->where('student_id', request()->student_id);
        }
        
        $resources = $query->paginate(Installment::$PAGE_LENGTH); 
        
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
            if ($item['paid'] != 1 && !isset($item['deleted']))
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
    public function update(Request $request) {
        try {
            $academicYear = AccountSetting::getCurrentAcademicYear();
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
                if (isset($item['id']) && $item['paid'] != 1 && isset($item['deleted'])) {
                    $installment = Installment::find($item['id']);
                    $installment? $installment->delete() : '';
                } else if (isset($item['id']) && $item['paid'] != 1) {
                    $installment = Installment::find($item['id']);
                    $installment->update($item);
                } else if (!isset($item['id']) && $item['paid'] == '0') {
                    $newItem = $item;
                    $newItem['academic_year_id'] = $academicYear->id;
                    $installment = Installment::create($newItem);
                }
            }
  
            watch(__('install the balance of student') . $student->name, "fa fa-calendar");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'));
    }
 
}
