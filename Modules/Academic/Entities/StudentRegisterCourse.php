<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentRegisterCourse extends Model
{
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
}
