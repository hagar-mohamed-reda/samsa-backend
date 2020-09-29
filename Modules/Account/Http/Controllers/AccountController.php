<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Account\Entities\Student;
use Modules\Account\Entities\StudentBalance;
use Modules\Account\Entities\AccountSetting;
use Modules\Account\Entities\Payment; 
use Modules\Account\Entities\Store; 
use Modules\Account\Entities\StudentPay; 
use App\User;
use DB;

class AccountController extends Controller
{
    
    /**
     * return student info
     * 
     * @return type
     */
    public function getStudentAccounting() {
        $student = null;
        if (request()->student_id) {
            $student = Student::query()
            ->with(['level', 'division', 'case_constraint', 'constraint_status', 'installments', 'payments'])
            ->find(request()->student_id);
        }
        
        $student->date = date("Y-m-d"); 
        return $student;
    }
    
    /**
     * pay money in store
     * 
     */
    public function pay(Request $request)
    {
        $user = $request->user;

        $resource = null;
        try {   
            $validator = validator($request->all(), [ 
                "value" =>  "required",    
                "student_id" =>  "required"       
            ]); 
            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
             
            $student = Student::find($request->student_id);  
            $resource = StudentPay::pay($request);
            
            $message = __('student {name} pay {value} in store');
            $message = str_replace("{name}", $student->name, $message);
            $message = str_replace("{value}", $request->value, $message);
            watch($message, "fa fa-money");
            return responseJson(1, $message, $resource);
        } catch (Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $resource);
    }
    
    

    public function searchStudent(Request $request) {
        return Student::query()//DB::table('students')
                ->where('name', 'like', '%'.$request->key.'%')
                ->orWhere('code', 'like', '%'.$request->key.'%')
                ->orWhere('national_id', 'like', '%'.$request->key.'%')
                ->take(20)
                ->get(["id", "name", "code"]); 
    }


    public function getStudentAvailableServices(Request $request) {
        $user = $request->user;
        $validator = validator($request->all(), [  
            "student_id" =>  "required"       
        ]); 
        if ($validator->failed()) {
            return [];
        }
            
        $student = Student::find($request->student_id); 
        return $student->getAvailableServices();

    }

    public function writeStudentNote(Request $request) {
        $validator = validator($request->all(), [  
            "notes" =>  "required",
            "student_id" =>  "required"       
        ]); 
        if ($validator->failed()) {
            return responseJson(0, __('write some notes'));
        }

        $student = Student::find($request->student_id); 

        if ($student->notes)
            $student->notes .=  "\n" . $request->notes;
        else
            $student->notes = $request->notes;

        $student->update();
        return responseJson(1, __('done'));
    }
 
}
