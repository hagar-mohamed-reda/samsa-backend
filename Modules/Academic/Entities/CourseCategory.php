<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    // table of bank
    protected $table = "academic_course_categories";
    
    protected $fillable = [
        'name',    
        'total_hours', 
        'required_hours'
    ];
     

    protected $appends = [
        'can_delete'
    ];

    public function getCanDeleteAttribute() {
        $valid = true;
        if ($this->courses()->count() > 0)
            $valid = false;
        
        return $valid;
    }


    public function courses() {
        return $this->hasMany("Modules\Academic\Entities\Course", "subject_category_id")->with(['division', 'category', 'level']);
    }
   
    
}
