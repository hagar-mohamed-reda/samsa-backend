<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // table of bank
    protected $table = "academic_courses";
    
    protected $fillable = [
        'name',    
        'code',       
        'year_work_degree',    
        'practical_degree',    
        'academic_degree', 
        'small_degree',    
        'large_degree',    
        'has_project', 
        'division_id', 
        'credit_hour', 
        'notes',
        'subject_category_id', 
        'is_required', 
        'book_price',  
        'failed_degree'
    ];

    protected $appends = [
        'can_delete', 'prerequsites', 'prerequsites_names'
    ];
 

    public function getPrerequsitesAttribute() {
        return implode(", ", $this->prequsites()->pluck('id')->toArray());
    }

    public function getPrerequsitesNamesAttribute() {
        return implode(", ", $this->prequsites()->pluck('name')->toArray());
    }

    public function getCanDeleteAttribute(){
        $valid = true;
        if ($this->registerStudents()->count() > 0)
            $valid = false;
        
        return $valid;
    }

     
   
    public function category() {
        return $this->belongsTo("Modules\Academic\Entities\CourseCategory", "subject_category_id");
    }

    public function division() {
        return $this->belongsTo("Modules\Divisions\Entities\Division", "division_id");
    }

    public function registerStudents() {
        return $this->hasMany("Modules\Academic\Entities\StudentRegisterCourse", "course_id");
    }

    public function prequsites() {
        $ids = CoursePrerequsite::where('course_id', $this->id)->pluck('id')->toArray();

        return Course::whereIn('id', $ids); 
    }


    public function prequsitesCourse() {
        return $this->hasMany("Modules\Academic\Entities\CoursePrerequsite", "course_id");
    }
     
}
