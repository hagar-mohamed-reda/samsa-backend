<?php

namespace App\Imports;

use Modules\Academic\Entities\StudentRegisterCourse;
use Modules\Academic\Entities\StudentResult;
use Modules\Account\Entities\AccountSetting;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Student\Entities\Student;
use Modules\Academic\Entities\Course;
use Modules\Academic\Entities\DegreeMap;
use App\Imports\StudentImport;
use App\Imports\CourseImport;
use DB;

class CourseRegisterWithResultImport implements ToModel {

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {
        // init variables 
        $degreeMap = DegreeMap::where('key', str_replace(" ", "", $row[15]))->first();
        $gpa = $row[14];
        $degree = $row[11];
        $student = StudentImport::insertStudent(array($row[0], $row[1], $row[2]));
        $course = CourseImport::insertCourse([$row[4], $row[5]]);


        // validate on the data 
        if (!$student || !$course || !$degreeMap || !is_numeric($gpa) || !is_numeric($degree)) 
            return null;
        // hold transaction in db
        //DB::beginTransaction();
        // register course to student first 
        $register = $this->register($course, $gpa, $student, $degreeMap);

        // set result to register course for student
        $result = $this->result($register, $degree);

        // commit transaction in db
        //DB::commit();

        return $result;
    }

    /**
     * register course to student 
     * 
     * @param type $course
     * @param type $gpa
     * @param type $student
     * @param type $degreeMap
     * @return type
     */
    public function register($course, $gpa, $student, $degreeMap) {
        try {

            $resource = StudentRegisterCourse::create([
                        "course_id" => $course->id,
                        "gpa" => $gpa,
                        "term_id" => AccountSetting::getCurrentTerm()->id,
                        "academic_year_id" => AccountSetting::getCurrentAcademicYear()->id,
                        "student_id" => $student->id,
                        "level_id" => $student->level_id,
                        "division_id" => $student->division_id,
                        "degree_map_id" => $degreeMap->id,
                        "user_id" => request()->user_id,
            ]);

            return $resource;
        } catch (\Exception $exc) {
            return null;
        }
    }

    /**
     * set the result for register course of student
     * 
     * @param type $register
     * @param type $degree
     */
    public function result($register, $degree) {
        try {
            $resource = StudentResult::create([
                        "course_id" => $register->course_id,
                        "student_id" => $register->student_id,
                        "term_id" => $register->term_id,
                        "academic_year_id" => $register->academic_year_id,
                        "level_id" => $register->level_id,
                        "date" => date('Y-m-d'),
                        "user_id" => request()->user_id,
                        "gpa" => $register->gpa,
                        "final_degree" => $degree
            ]);

            return $resource;
        } catch (\Exception $exc) {
            return null;
        }  
    }

}
