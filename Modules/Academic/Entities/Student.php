<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\Student as StudentOrigin;

class Student extends StudentOrigin
{ 
    /**
     * calculate gpa of all acadmic year of the student and it's terms
     * and cache it in db
     */
    public function getAllGpa() {
        $academicYears = StudentRegisterCourse::query()
                ->where('student_id', $this->id)
                ->select('academic_year_id')
                ->distinct('academic_year_id')
                ->pluck('academic_year_id')
                ->toArray(); 
        foreach($academicYears as $item) {
            $terms = StudentRegisterCourse::query()
                ->where('student_id', $this->id)
                ->where('academic_year_id', $item)
                ->select('term_id')
                ->distinct('term_id')
                ->pluck('term_id')
                ->toArray();
            foreach($terms as $term) {
                $gpaCalculator = new GpaCalculator($this, $item, $term);
                $gpa = $gpaCalculator->getGPA();
                $this->storeGpa($this->id, $item, $term, $gpa);
            } 
        } 
    }
    
    public function storeGpa($studentId, $academicYearId, $termId, $gpa) {
        $row = StudentGpa::where('student_id', $studentId)
                ->where('academic_year_id', $academicYearId)
                ->where('term_id', $termId)
                ->first();
        
        if (!$row) {
            $row = StudentGpa::create([
                "student_id" => $studentId,
                "academic_year_id" => $academicYearId,
                "term_id" => $termId,
                "gpa" => $gpa
            ]);
        } 
        return $row;
    }
      
    public function getGpa() {
        $gpa =  StudentGpa::query()
                ->where('student_id', $this->id)
                ->avg("gpa");
        return $gpa? $gpa : 0;
    }
}
