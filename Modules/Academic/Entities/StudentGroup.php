<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Entities\AccountSetting;
use DB;

class StudentGroup extends Model {

    // table of bank
    protected $table = "academic_student_groups";
    protected $fillable = [
        'doctor_id', 'student_id', 'academic_year_id', 'term_id'
    ];

    public function doctor() {
        return $this->belongsTo("Modules\Academic\Entities\Doctor", 'doctor_id');
    }

    public static function addStudentToGroup($student) {
        $year = AccountSetting::getCurrentAcademicYear();
        $term = AccountSetting::getCurrentTerm();
        $studentTotal = DB::table('students')
                ->where('level_id', $student->level_id)
                ->count();
        $doctors = DoctorLevel::where('level_id', $student->level_id)->get();
        $doctorsCount = DoctorLevel::where('level_id', $student->level_id)->count();
        $groupCount = $studentTotal / $doctorsCount;
        $isGrouped = false;

        foreach ($doctors as $doctorLevel) {
            // doctor group
            $doctorGroupCount = StudentGroup::where('doctor_id', $doctorLevel->doctor_id)->count();

            if ($doctorGroupCount < $groupCount) {
                StudentGroup::create([
                    "student_id" => $student->id,
                    "doctor_id" => $doctorLevel->doctor_id,
                    "academic_year_id" => $year->id,
                    "term_id" => $term->id,
                ]);
                $isGrouped = true;
                return;
            }
        }

        if (!$isGrouped) {
            $doctorLevel = DoctorLevel::where('level_id', $student->level_id)->first();
            if (!$doctorLevel)
                return;
            StudentGroup::create([
                "student_id" => $student->id,
                "doctor_id" => $doctorLevel->doctor_id,
                "academic_year_id" => $year->id,
                "term_id" => $term->id,
            ]);
        }
    }

}
