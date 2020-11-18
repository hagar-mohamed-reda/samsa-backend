<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model {

    // table of bank
    protected $table = "academic_student_groups";
    protected $fillable = [
        'doctor_id', 'student_id', 'academic_year_id', 'term_id'
    ];

    public function doctor() {
        return $this->belongsTo("Modules\Academic\Entities\Doctor", 'doctor_id');
    }
}