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


class StudentResultController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function get()
    {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();
		$course = Course::find(request()->course_id);  
        
        $query = DB::table('students')->select(
                'id', 'code', 'set_number', 'name', 'level_id', 'division_id',
                DB::raw('id as student_id'),
                DB::raw($term->id.' as term_id'), 
                DB::raw($year->id.' as academic_year_id'), 
                DB::raw('(select name from academic_years where academic_years.id = academic_year_id) as academic_year_name'),
                DB::raw('(select name from terms where terms.id = term_id) as term_name'),
                DB::raw('(select name from levels where levels.id = level_id) as level_name'),
                DB::raw('(select name from divisions where divisions.id = division_id) as division_name'),
                DB::raw('(select final_degree from academic_student_courses_result where student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as final_degree '),
                DB::raw('(select date from academic_student_courses_result where student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as date '),
                DB::raw('(select course_id from academic_student_courses_result where student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as course_id '),
                DB::raw('(select name from academic_student_courses_result, academic_courses where academic_courses.id=academic_student_courses_result.course_id and student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as course_name '),
                DB::raw('(select large_degree from academic_student_courses_result, academic_courses where academic_courses.id=academic_student_courses_result.course_id and student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as large_degree '),
                DB::raw('(select code from academic_student_courses_result, academic_courses where academic_courses.id=academic_student_courses_result.course_id and student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.' and course_id='.request()->course_id.') as course_code ')
                );
        
        //$query = $query->whereRaw('(select course_id from academic_student_courses_result where student_id = students.id and term_id='.$term->id.' and academic_year_id='.$year->id.') = ?', request()->course_id);
        
        if (request()->level_id > 0)
            $query = $query->where('level_id', request()->level_id);
        
		
		$response = $query->paginate(10);
		
		// add result to db
		foreach($response as $item) {
			if (!$item->course_id) {
				$item->course_id = optional($course)->id;
				$item->course_code = optional($course)->code;
				$item->course_name = optional($course)->name;
				$item->large_degree = optional($course)->large_degree;
			}
		}
		
        return $response;
    }
     
    /**
     * add the result of student if not exist
     * or update on it if it exist
     * @param Request $request
     * @return type
     */
    public function update(Request $request) { 
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
                    $row = StudentResult::create($item);
                }
                
                // calculate gpa and update it.
                $row->calculateCourseGpa(); 
            } 
            watch(__("assign result for the students "), "fa fa-calendar");
            return responseJson(1, __('done'));
        } catch (Exception $exc) {
            return responseJson(0, $exc->getMessage());
        }
    }
 
 
 
 
 
}
