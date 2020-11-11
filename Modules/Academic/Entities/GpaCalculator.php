<?php

namespace Modules\Academic\Entities;

use Modules\Academic\Entities\Student;
use Modules\Account\Entities\AccountSetting;
use Modules\Settings\Entities\AcademicYear;
use App\Term;

class GpaCalculator {
    
    /**
     * student object
     * @var type 
     */
    private $student = null;
     
    /**
     * academic year of register
     * @var type 
     */
    private $academicYear = null;
    
    /**
     * term of register
     * @var type 
     */
    private $term = null;
    
    public function __construct(Student $student, AcademicYear $academicYear, Term $term) {
        $this->student = $student;
        $this->term = $term;
        $this->academicYear = $academicYear;
    }
    
    public function getRegisterCourses() {
        return StudentRegisterCourse::query()
                ->join('academic_courses', 'academic_courses.id', '=', 'course_id')
                ->where('student_id', $this->student->id)
                ->where('academic_year_id', $this->academicYear->id)
                ->where('term_id', $this->term->id)
                ->select('*', 'academic_student_register_courses as id');
    }
    
    public function getRegisterHours() {
        return $this->getRegisterCourses()->sum('credit_hour');
    }
    
    public function getGPA() {
        $gpSum = 0;
        $registerHours = $this->getRegisterHours();
        
        foreach ($this->getRegisterCourses()->get() as $item) {
            $gpSum += $item->getGP();
        }
        
        $gpa = $gpSum / $registerHours;
        return $gpa;
    }
}
