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
        $currentYear = self::getCurrentAcademicYear();
        $valid = true;
        $reason = "";

        // check on case constraint
        if ($student->case_constraint_id == 1) {
            $valid = false;
            $reason = __('The service is not available for an application');
        }

        // check if there is old value
        else if ($student->old_balance > 0) {
            $valid = false;
            $reason = __("The student was given a previous fee");
        }

        // check if student take this service
        else if (!$service->repeat) {
            if (StudentService::where('student_id', $student->id)->where('service_id', $service->id)->exists()) {
                $valid = false;
                $reason = __("The student got the service before");
            }
        }

        // check on student installments
        else if ($service->from_installment_id) {
            $count = Payment::where('student_id', $student->id)
                            ->whereIn('model_type', ['installment', 'academic_year_expense'])
                            ->count();

            $sum = Payment::where('student_id', $student->id)
                            ->whereIn('model_type', ['installment', 'academic_year_expense'])
                            ->sum('value');

            $total = AcademicYearExpense::query()
            ->where('academic_year_id', $currentYear->id)
            ->where('level_id', $student->level_id)
            ->first()->details()->sum('value');

            $percent = ($sum / $total) * 100; 

            $service->percent = $percent;
            $service->installment_count = $count;

            if ($count < $service->from_installment_id || $percent < $service->installment_percent) {
                $valid = false;
                $reason = __("The student did not pay the required percentage of the installment number ") . $service->from_installment_id;
            }
        }

        // check on student level
        else if ($service->except_level_id) {
            if ($service->except_level_id == $student->level_id) {
                $valid = false;
                $reason = __("The service is not available for the student level");
            }
        }

        // check on student level
        else if ($service->division) {
            if ($service->division_id != $student->division_id) {
                $valid = false;
                $reason = __("The service is only available for division ") . optional($service->division)->name;
            }
        }

        return [
            "valid" => $valid,
            "reason" => $reason
        ];
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
