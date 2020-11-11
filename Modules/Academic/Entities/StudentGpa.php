<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentGpa extends Model
{
    // table of bank
    protected $table = "academic_student_gpa";
    
    protected $fillable = [
  	'student_id',
        'academic_year_id',
        'term_id',
        'gpa'
    ];
      
     
}
