<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Academic\Entities\DegreeMap;

class StudentResult extends Model
{
    // table of bank
    protected $table = "academic_student_courses_result";
    
    protected $fillable = [
  	'course_id',
        'student_id',
        'mid_degree',
        'final_degree',
        'term_id',
        'academic_year_id',
        'level_id',
        'date',
        'user_id',
        'gpa'
    ];
    
    
    public function course() {
        return $this->belongsTo("Modules\Academic\Entities\Course", "course_id");
    }
    
    public function student() {
        return $this->belongsTo("Modules\Academic\Entities\Student", "student_id");
    }
    
    public function academicYear() {
        return $this->belongsTo("Modules\Settings\Entities\AcademicYear", "academic_year_id");
    }
    
    public function level() {
        return $this->belongsTo("Modules\Settings\Entities\level", "academic_year_id");
    }
    
    public function term() {
        return $this->belongsTo("Modules\Settings\Entities\Term", "term_id");
    }
    
    public function getDegreeMap() {
        $percent = ($this->final_degree / $this->course->large_degree) * 100;
        $degreeMap = DegreeMap::where('percent_from', "<=", $percent)->where('percent_to', '>=', $percent)->first();
        return $degreeMap;
    }
     
   
    public function calculateCourseGpa() { 
        $degreeMap = $this->getDegreeMap(); 
        $this->update([
            "gpa" => optional($degreeMap)->gpa
        ]);
        $studentRegisterCourse = StudentRegisterCourse::where('student_id', $this->id)
                ->where('course_id', $this->id)
                ->latest()
                ->first();
        
        if ($studentRegisterCourse) {
            $studentRegisterCourse->update([
                "degree_map_id" => optional($degreeMap)->id,
                "gpa" => optional($degreeMap)->gpa,
                "student_degree" => $this->final_degree,
            ]);
        }
    }
     
}
