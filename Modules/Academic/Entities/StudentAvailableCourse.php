<?php

namespace Modules\Academic\Entities;

use Modules\Account\Entities\Student;

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

    public function __construct(Student $student) {
        $this->student = $student;
        $this->course = Course::query();
        $this->settings = AcademicSetting::query();
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
        if (optional($this->settings->find(7))->value != 1) {
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
             if ($course->isOpen()) {
                 $newCourses[] = $course;
             }
        }
        $this->courses = $newCourses;
    }

    public function getCourses() {
        $this->levelFilter();
        $this->openCourseFilter();
        $this->prequsitesFilter();

        return $this->courses;
    }

}
