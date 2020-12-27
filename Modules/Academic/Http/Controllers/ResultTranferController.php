<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\StudentResult; 
use Modules\Academic\Entities\Student; 
use Modules\Academic\Entities\Course; 
use Modules\Student\Entities\Student as StudentOrigin; 
use Modules\Account\Entities\AccountSetting;
use DB;
use Modules\Academic\Entities\ResultTransfer;
use Modules\Academic\Entities\StudentResultTransfer;
use Modules\Academic\Entities\GpaCalculator;


class ResultTranferController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm(); 
        return ResultTransfer::where('term_id', $term->id)->where('academic_year_id', $year->id)->first();
    }
     
    /**
     * add the result of student if not exist
     * or update on it if it exist
     * @param Request $request
     * @return type
     */
    public function start(Request $request) {  
        $students = StudentResultTransfer::with(['level'])->get();
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm(); 
        $resultTransfer = ResultTransfer::where('term_id', $term->id)->where('academic_year_id', $year->id)->first();
        try {  
            if ($resultTransfer) {
                return responseJson(0, "النتيجة رحلت بالفعل");
            }
            
            $problemStudents = [];
            foreach($students as $student) {
                $valid = $student->checkIfCanTransferToAnotherLevel();
                $student->startCalculateGpa();
                if (!$valid) {
                    $student->faild_transfer_reason = $student->failedTransferReason;
                    $problemStudents[] = $student;
                }
            } 
            
            ResultTransfer::create([
                "term_id" => $term->id,
                "user_id" => optional($request->user)->id,
                "academic_year_id" => $year->id,
            ]);
            
            watch(__("result_transfer"), "fa fa-calendar");
            return responseJson(1, __('done'), $problemStudents);
        } catch (\Exception $exc) {
            return responseJson(0, $exc->getMessage());
        }
    }
 
 
 
 
 
}
