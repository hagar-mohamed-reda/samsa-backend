<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class CoursePrerequsite extends Model
{
    // table of bank
    protected $table = "acadmic_course_prerequsites";
    
    protected $fillable = [
        'course_id',   
        'related_course_id'
    ];
     
   
    public function course() {
        return $this->belongsTo("Modules\Academic\Entities\Course", "course_id");
    }
 
    public function relatedCourse() {
        return $this->belongsTo("Modules\Academic\Entities\Course", "related_course_id");
    }

     
}
