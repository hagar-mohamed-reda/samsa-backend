<?php

namespace Modules\Academic\Entities;

use Modules\Account\Entities\Student;
use Modules\Account\Entities\Payment;
use Modules\Account\Entities\AccountSetting;

class StudentAvailableCourse {

    /**
     * student object
     * @var type Student
     */
    private $student = null;

    /**
     * query of course
     * @var type
     */
    private $query = null;

    /**
     * academic settings
     * @var type Array
     */
    private $settings = null;

    /**
     * courses
     * @var Array
     */
    private $courses = [];

    /**
     * current academic year
     * @var Array
     */
    private $year = [];

    public function __construct(Student $student) {
        $this->student = $student;
        $this->course = Course::with(['prequsitesCourse']);
        $this->settings = AcademicSetting::query();
		$this->year = AccountSetting::getCurrentAcademicYear();
        $this->courses = Course::all();
    }

    public function levelFilter() {
        if (optional($this->settings->find(6))->value != 1) {
            $newCourses = [];
            foreach ($this->courses as $course) {
                if ($course->level_id == $this->student->level_id)
                    $newCourses[] = $course;
            }
            $this->courses = $newCourses;
        }
    }

    public function prequsitesFilter() {
        if (optional(AcademicSetting::find(7))->value != 1) {
            $newCourses = [];
            foreach ($this->courses as $course) {
                if ($course->prequsitesCourse()->count() > 0) {
                    $valid = true;
                    foreach ($course->prequsites()->get() as $item) {
                        if (!$item->isRegistered($this->student->id)) {
                            $valid = false;
                        }
                    }
                    //
                    if ($valid) {
                        $newCourses[] = $course;
                    }
                } else {
                    $newCourses[] = $course;
                }
            }
            $this->courses = $newCourses;
        }
    }

    public function openCourseFilter() {
        $newCourses = [];
        foreach ($this->courses as $course) {
             if ($course->isOpen() || $course->is_not_credit_hour) {
                 $newCourses[] = $course;
             }
        }
        $this->courses = $newCourses;
    }

	public function filterPaidService() {
        $newCourses = [];
		foreach($this->courses as $course) {
			// check if paid
			if ($course->service_id > 0) {
				$paid = Payment::where('model_type', 'service')
				->where('student_id', $this->student->id)
				->where('model_id', $course->service_id)
				->where('academic_year_id', $this->year->id)
				->exists();
				if ($paid) {
					$newCourses[] = $course;
				}
			} else {
				$newCourses[] = $course;
			}
		}
        $this->courses = $newCourses;
	}

    public function getCourses() {
        $this->levelFilter();
        $this->openCourseFilter();
        $this->prequsitesFilter();
		$this->filterPaidService();

        return $this->courses;
    }

}
