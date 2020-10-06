<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\AcademicYear;

class AccountSetting extends Model
{

    protected $table = "account_settings";

    protected $fillable = [
        'id', 'name', 'value'
    ];

    /**
     * return current academic year of system
     *
     * @return AcademicYear
     */
    public static function getCurrentAcademicYear() {
        // get current year
        $currentYear = date("Y");

        // next year
        $nextYear = $currentYear + 1;

        // academic year name
        $name = $currentYear."-".$nextYear;

        return AcademicYear::where('name', $name)->first();
    }

    /**
     * get current term
     *
     * @return Term
     */
    public static function getCurrentTerm() {
        // get current date
        $date = date('m-d');

        return Term::where('id', 1)->first();
    }


    /**
     * check if the student can take service
     */
    public static function canStudentGetService(Service $service, Student $student) {
        $valid = true;

        // check if there is old value
        if ($student->old_balance > 0)
            $valid = false;

        // check if student take this service
        if (!$service->repeat) {
            if (StudentService::where('student_id', $student->id)->where('service_id', $service->id)->exists()) {
                $valid = false;
            }
        }

        // check on student installments
        if ($service->from_installment_id) {
            if (Payment::where('student_id', $student->id)->whereIn('type', ['installment', 'academic_year_expense'])->count() < $service->from_installment_id)
                $valid = false;
        }

        // check on student level
        if ($service->except_level_id) {
            if ($service->except_level_id == $student->level_id)
                $valid = false;
        }

        // check on student level
        if ($service->division) {
            if ($service->division != $student->division)
                $valid = false;
        }

        return $valid;
    }

    public static function updateSetting($id, $name, $value) {
        $accountSetting = AccountSetting::find($id);

        if ($accountSetting) {
            $accountSetting->update([
                "name" => $name,
                "value" => $value,
            ]);
        } else {
            $accountSetting = AccountSetting::create([
                "id" => $id,
                "name" => $name,
                "value" => $value,
            ]);
        }
        return $accountSetting;
    }


    public static function getOldBalanceStore() {
        return Store::find(optional(AccountSetting::find(1))->value);
    }
}
