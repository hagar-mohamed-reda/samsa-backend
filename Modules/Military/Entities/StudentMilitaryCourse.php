<?php

namespace Modules\Military\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentMilitaryCourse extends Model
{
    protected $table = 'military_course_collection_student';
    protected $fillable = ['student_id', 'military_course_collection_id', 'status'];


    public function student(){
        return $this->belongsTo('Modules\Student\Entities\Student', 'student_id');
    }
}
