<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\AccountSetting;

class StudentRegisterCourse extends Model {

    // table of bank
    protected $table = "academic_student_register_courses";
    protected $fillable = [
        'course_id',
        'gpa',
        'term_id',
        'academic_year_id',
        'student_id',
        'level_id',
        'division_id',
        'degree_map_id'
    ];

    public function course() {
        return $this->belongsTo("Modules\Academic\Entities\Course", "course_id");
    }

    public function academicYear() {
        return $this->belongsTo("Modules\Divisions\Entities\AcademicYear", "academic_year_id");
    }

    public function student() {
        return $this->belongsTo("Modules\Account\Entities\Student", "student_id");
    }

    public function division() {
        return $this->belongsTo("Modules\Divisions\Entities\Division", "division_id");
    }

    public function level() {
        return $this->belongsTo("Modules\Divisions\Entities\Level", "level_id");
    }

    public function term() {
        return $this->belongsTo("App\Term", "term_id");
    }

    public function getGP() {
        return optional($this->course)->credit_hour * optional($this->course)->gpa;
    }

    public static function add(Request $request) {
        $student = Student::find($request->student_id);
        $courses = $request->courses;
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();

        try {
            // delete old
            StudentRegisterCourse::query()
                    ->where('student_id', $student->id)
                    ->where('academic_year_id', $year->id)
                    ->where('term_id', $term->id)
                    ->delete();
            
            // add new
            foreach($courses as $course) {
                StudentRegisterCourse::create([
                    "student_id" => $student->id,
                    "academic_year_id" => $year->id,
                    "term_id" => $term->id,
                    "course_id" => $course['id'],
                ]);
            }
            
            responseJson(1, __('done'));
        } catch (\Exception $exc) {
            responseJson(0, $exc->getMessage());
        }
    }

}
