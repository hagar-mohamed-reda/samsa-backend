<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\StudentResult; 
use Modules\Account\Entities\AccountSetting;


class StudentResultController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        return StudentResult::latest()->get();
    }
     
    /**
     * add the result of student if not exist
     * or update on it if it exist
     * @param Request $request
     * @return type
     */
    public function add(Request $request) { 
        $result = $request->result; 
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm(); 
        try {  
            foreach($result as $item) {
                $item['date'] = date('Y-m-d');
                $row = StudentResult::query()
                        ->where('student_id', $item['student_id'])
                        ->where('academic_year_id', $year->id)
                        ->where('term_id', $term->id)
                        ->first();
                if ($row) {
                    $row->update($item);
                } else {
                    StudentResult::create($item);
                }
            } 
            watch(__("assign result for the students "), "fa fa-calendar");
            return responseJson(1, __('done'));
        } catch (\Exception $exc) {
            return responseJson(0, $exc->getMessage());
        }
    }
 
 
 
 
 
}
