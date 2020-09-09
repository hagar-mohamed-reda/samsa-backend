<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Account\Entities\Student;
use Modules\Account\Entities\StudentBalance;
use Modules\Account\Entities\AccountSetting;
use Modules\Account\Entities\Payment;
use App\User;

class AccountController extends Controller
{
    /**
     * pay money in store
     * 
     */
    public function pay(Request $request)
    {
        $resource = null;
        try { 
            $user = $request->user();
            
            if (!$user) {
                return responseJson(0, __('login first'));
            }
            
            $validator = validator($request->all(), [ 
                "value" =>  "required",    
                "student_id" =>  "required",    
                "user_id" =>  "required",    
            ]); 
            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
            
            $student = Student::find($request->student_id);
            $resource = $this->performPayment($student, $value, $user);
            
            $message = __('student {name} pay {value} in store');
            $message = str_replace("{name}", $student->name, $message);
            $message = str_replace("{value}", $request->value, $message);
            log($message, "fa fa-money");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $resource);
    }
    
    public function performPayment(Student $student, $value, User $user) { 
        // old balance
        $oldBalance = $student->getStudentBalance()->getOldBalance();
        
        // type of payment
        $modelType = "";
        
        if ($oldBalance > 0) {
            if ($student->is_old_installed)
                $modelType = "installment";
            else
                $modelType = "academic_year_expense";
        } else {
            if ($student->is_current_installed)
                $modelType = "installment";
            else
                $modelType = "academic_year_expense";
        }
        
        $paidModel = $student->getStudentBalance()->getPaidModel();
         
        $payment = Payment::create([
            "student_id" => $student->id,
            "store_id" => 1,
            "date" => date('Y-m-d'),
            "value" => $value,
            "user_id" => $user->id,
            "model_type" => $modelType,
            "model_id" => optional($paidModel)->id,
        ]);
        
        if ($modelType == 'installment' && $paidModel) {
            $paidModel->update([
                "paid" => "1"
            ]);
        } 
         
        return $payment;
    }
 
}
