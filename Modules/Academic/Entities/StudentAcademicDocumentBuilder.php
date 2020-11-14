<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student as StudentOrigin;

class StudentAcademicDocumentBuilder
{
    
    private $student = null;
    
    public function __construct($student) {
        $this->student = $student;
    }
    
        
     
}
