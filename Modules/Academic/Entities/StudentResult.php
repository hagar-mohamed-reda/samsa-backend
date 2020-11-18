<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

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
     
      
     
}
