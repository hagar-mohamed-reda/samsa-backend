<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\AccountSetting;

class OpenCourse extends Model
{
    // table of bank
    protected $table = "academic_open_courses";
    
    protected $fillable = [
        'course_id',  'term_id', 'academic_year_id', 'date'
    ];
      
    public static function currentOpenCourses() {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();

        return OpenCourse::where('term_id', $term->id)->where('academic_year_id', $year->id);
    }
       
    public static function currentCourses() { 
        $ids = self::currentOpenCourses()->pluck('course_id')->toArray();

        return Course::whereIn('id', $ids)->get();
    }

}
