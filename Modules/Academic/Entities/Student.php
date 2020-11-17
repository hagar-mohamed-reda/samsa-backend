<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\Student as StudentOrigin;
use Modules\Account\Entities\AccountSetting;
use Modules\Divisions\Entities\Level;
use App\Term;

class Student extends StudentOrigin
{ 
    
    protected $appends = [
        'register_hours',
        'gpa',
        'image',
        'current_register_courses', 
        'academic_document',
        'warning'
    ];
    
    public function getWarningAttribute() {
        $requiredGpa = optional(AcademicSetting::find(2))->value;
        $times = StudentGpa::where('student_id', $this->id)->where('gpa', '<', $requiredGpa)->count();
        
        $warning = "الطالب حصل على معدل تراكمى اقل من " . $requiredGpa .  " لعدد " . $times . " مرات ";
        
        return $times > 0? $warning : null;
    }
    
    public function getAcademicDocumentAttribute() {
        $levelIds = $this->registerCourses()->pluck('level_id')->toArray();
        $levels = Level::whereIn('id', $levelIds)->get();
        
        foreach($levels as $level) {
            $termIds = $this->registerCourses()->where('level_id', $level->id)->pluck('term_id')->toArray();
            $terms = Term::whereIn('id', $termIds)->get();
            foreach($terms as $term) {
                $courseids =  $this->registerCourses()->where('level_id', $level->id)
                        ->where('term_id', $term->id)->pluck('course_id')->toArray();
                $term->courses = $this->registerCourses()
						->with(['division'])
						->join('academic_courses', 'academic_courses.id', '=', 'course_id')
						->where('academic_student_register_courses.level_id', $level->id)
                        ->where('term_id', $term->id)
						->select('*', 'academic_student_register_courses.id as id', 'academic_student_register_courses.created_at as created_at')
						->get();
				//Course::whereIn('id', $courseids)->get();
				//
            }
            $level->terms = $terms;
			
        } 
        
        return $levels;
    }

    
    public function getCurrentRegisterCoursesAttribute() {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();
        //
        $ids = StudentRegisterCourse::query()
                    ->where('student_id', $this->id)
                    ->where('academic_year_id', $year->id)
                    ->where('term_id', $term->id)
                    ->pluck('course_id')
                    ->toArray();
        
        return Course::whereIn('id', $ids)->get();
    }
    
    public function getRegisterHoursAttribute() {
        $successGpa = optional(AcademicSetting::find(2))->value;
        $ids = $this->registerCourses()->where('gpa', '>=', $successGpa)->pluck('course_id')->toArray();
        return Course::whereIn('id', $ids)->sum('credit_hour');
    }
    
    public function registerCourses() {
        return $this->hasMany("Modules\Academic\Entities\StudentRegisterCourse", 'student_id');
    }
    
    public function courses() {
        return $this->hasManyThrough("Modules\Academic\Entities\Course", 'Modules\Academic\Entities\StudentRegisterCourse', 'student_id', 'id', 'id', 'course_id');
    }
    
    public function doctorGroup() {
        return DoctorLevel::where('level_id', $this->level_id)->first();
    }
	
	public function group() {
		return StudentGroup::where('student_id', $this->id)->latest()->first();
	}


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
