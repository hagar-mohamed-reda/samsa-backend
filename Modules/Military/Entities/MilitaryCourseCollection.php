<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class MilitaryCourseCollection extends Model
{
    protected $table = 'military_course_collection';
    
    protected $fillable = ['code', 'military_course_id', 'academic_year_id', 'starts_in', 'ends_in', 'notes','created_at', 'updated_at'];


    public function militartCourse(){
        return $this->belongsTo('Modules\Military\Entities\MilitaryCourse', 'military_course_id');
    }

    public function student(){
        return $this->belongsToMany('Modules\Student\Entities\Student');
    }
    
     public function militaryCourseCollectionStudent(){
        return $this->hasMany('Modules\Military\Entities\StudentMilitaryCourse');
    }
    public function academicYear(){
       return $this->belongsTo('Modules\Settings\Entities\AcademicYear', 'academic_year_id');
    }
}
