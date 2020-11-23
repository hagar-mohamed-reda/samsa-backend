<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\CaseConstraint;
use Modules\Student\Entities\Student;


class CaseConstraintConverter 
{
    /**
     * student object
     * @var type 
     */
    private $student = null;
    
    /**
     * case constraint
     * @var type 
     */
    private $caseConstraint = null;
    
    public function __construct($student, $caseConstraint) {
        $this->student = $student;
        $this->caseConstraint = $caseConstraint;
    }
    
    public function change() {
        if ($this->caseConstraint == 1) 
            return $this->toCase1();
        else if ($this->caseConstraint == 2) 
            return $this->toCase2();
        
        return;
    }

    /**
     * if case constraint with id == 1
     * 
     */
    public function toCase1() { 
        if (!$this->student->case_constraint_id) {
            $this->student->case_constraint_id = 1;
            $this->student->update();
        }
    }
    
    /**
     * if case constraint with id == 2
     * 
     */
    public function toCase2() {
        if ($this->student->case_constraint_id == 1 /*&& $this->student->acceptance_code*/) {
            $this->student->case_constraint_id = 2;
            $this->student->update();
        }
    }
}
