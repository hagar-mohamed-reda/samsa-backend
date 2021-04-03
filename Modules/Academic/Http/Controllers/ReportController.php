<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Academic\Entities\CoursePrerequsite;
use Modules\Academic\Entities\StudentResult;
use Modules\Academic\Entities\Student;
use Modules\Academic\Entities\Course;
use Modules\Student\Entities\Student as StudentOrigin;
use Modules\Account\Entities\AccountSetting;
use DB;


class ReportController extends Controller
{
    /**
     * return list of courses
     * @return Response
     */
    public function getResult()
    {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();
        //request()->courses = "";

        $query = DB::table('students')
                ->join('academic_student_courses_result', 'academic_student_courses_result.student_id', '=', 'students.id')
                ->where('term_id', $term->id)
                ->where('academic_year_id', $year->id)
                ->select(
                'code', 'set_number', 'name', 'division_id',
                DB::raw('students.id as student_id'),
                DB::raw('students.id as id'),
                DB::raw('students.level_id as level_id'),
                DB::raw($term->id.' as term_id'),
                DB::raw($year->id.' as academic_year_id'),
                DB::raw('(select name from academic_years where academic_years.id = academic_year_id) as academic_year_name'),
                DB::raw('(select name from terms where terms.id = term_id) as term_name'),
                DB::raw('(select name from levels where levels.id = students.level_id) as level_name'),
                DB::raw('(select name from divisions where divisions.id = division_id) as division_name'),

                DB::raw('(select name from academic_courses where course_id = academic_courses.id) as course_name'),
                DB::raw('(select code from academic_courses where course_id = academic_courses.id) as course_code'),
                DB::raw('(select large_degree from academic_courses where course_id = academic_courses.id) as large_degree'));

        if (request()->levels > 0)
            $query = $query->whereIn('students.level_id', request()->levels);

        if (request()->divisions > 0)
            $query = $query->whereIn('division_id', request()->divisions);

        if (request()->courses)
            $query = $query->whereIn('course_id', request()->courses);

        if (request()->student_id > 0)
            $query->where('student_id', request()->student_id);

	$response = $query->paginate(60);

        return $response;
    }


}
