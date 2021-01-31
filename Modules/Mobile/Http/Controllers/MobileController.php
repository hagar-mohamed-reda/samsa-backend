<?php

namespace Modules\Mobile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AccountSetting;
use Modules\Academic\Entities\Student;
use Modules\Account\Entities\Student as StudentAccount;
use Modules\Academic\Entities\StudentResult;
use DB;

class MobileController extends Controller
{
    /**
     * get analysis of main activities of mobile
     * 
     */
    public function getAnalysis()
    { 
        $student = Student::where('api_token', request()->api_token)->first();
        
        $data = [
            "academic_year" => AccountSetting::getCurrentAcademicYear(),
            "term" => AccountSetting::getCurrentTerm(),
            "gpa" => optional($student)->gpa
        ];
        return responseJson(1, __('done'), $data);
    }
    
    /**
     * get notification for student
     * 
     * @return type
     */
    public function getNotifications() { 
        return DB::table('notification')->where('user_id', optional(request()->user)->id)->get();
    }
    
    /**
     * get contact info
     * 
     * @return type
     */
    public function getAppInfo() {
        return [
            "location" => [
                "lat" => 3.18888,
                "lng" => 3.18888
            ],
            "phone" => "01123604214",
            "email" => "admin@msa.com",
            "address" => "msa address",
            "website" => "www.msa.com",
            "about" => "ajf klf skldfj kldsfj kldsfj kdlf jkdslf jkdlsfj kdslf jkldsfj kl"
        ];
    }
    
    /**
     * get contact info
     * 
     * @return type
     */
    public function getStudentAcademic() {
        $student = Student::find(optional(request()->user)->id);
        return $student;
    }
    
    /**
     * get student availables services
     * 
     * @return type
     */
    public function getStudentServices() {
        $resources = DB::table('account_services')->where('is_mobile', '1')->get();
        return $resources;
    }
    
    /**
     * get student availables services
     * 
     * @return type
     */
    public function getStudentResult() { 
        
        $resultPublished = DB::table('academic_publish_result')
                ->where('academic_year_id', optional(AccountSetting::getCurrentAcademicYear())->id)
                ->where('term_id', optional(AccountSetting::getCurrentTerm())->id)
                ->exists();
        
        if (!$resultPublished) {
            return [];
        }
        else {
            return StudentResult::query()
                    ->where('student_id', optional($request->user)->id)
                    ->where('academic_year_id', optional(AccountSetting::getCurrentAcademicYear())->id)
                    ->where('term_id', optional(AccountSetting::getCurrentTerm())->id)
                    ->with(['course'])
                    ->get();
        }
    }
    
    
    public function getStudentAccount() {
        return StudentAccount::with(['installments'])->find(optional(request()->user)->id);
    }
}
