<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\AcademicYear;
use DB;

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
        return Term::find(optional(DB::table('globale_settings')->find(6))->value);
    }


    /**
     * check if the student can take service
     */
    public static function canStudentGetService(Service $service, Student $student) {
        $currentYear = self::getCurrentAcademicYear();
        $valid = true;
        $reason = "";
        $percent = 0;

        // check on case constraint
        if ($student->case_constraint_id == 1 && $valid) {
            $valid = false;
            $reason = __('The service is not available for an application');
        }

        // check if there is old value
        if ($student->old_balance > 0 && $valid) {
            $valid = false;
            $reason = __("The student was given a previous fee");
        }

        // check if student take this service
        if (!$service->repeat && $valid) {
            if (StudentService::where('student_id', $student->id)->where('service_id', $service->id)->exists()) {
                $valid = false;
                $reason = __("The student got the service before");
            }
        }

        // check on student installments
        if ($service->from_installment_id && $valid) {
            $count = Payment::where('student_id', $student->id)
                            ->whereIn('model_type', ['installment', 'academic_year_expense'])
                            ->count();


            $total = AcademicYearExpense::query()
                ->where('academic_year_id', $currentYear->id)
                ->where('level_id', $student->level_id)
                ->first()->details()
                ->where('priorty', ($service->from_installment_id + 1))
                ->sum('value');

            $ids = AcademicYearExpense::query()
                ->where('academic_year_id', $currentYear->id)
                ->where('level_id', $student->level_id)
                ->first()->details()
                ->where('priorty', ($service->from_installment_id + 1))
                ->pluck('id')->toArray();

            $sum = 0;
            if ($student->is_current_installed || $student->is_old_installed) {
                $total = 0;

                $rows = installment::where('student_id', $student->id)->get();

                for($i = 0; $i < count($rows); $i ++) {
                    $row = $rows[$i];
                    if (($i + 1) == $service->from_installment_id) 
                        $total = $row->value;
                }
 
                $sum = 0;
                for($i = 0; $i < count($rows); $i ++) {
                    $row = $rows[$i];
                    if (($i + 1) == $service->from_installment_id && $row->paid == 1) 
                        $sum = $row->value;
                } 

            } else {
                $sum += Payment::where('student_id', $student->id)
                            ->where(function($q)  use ($ids) {
                                $q->where('model_type', 'academic_year_expense')
                                ->whereIn("model_id", $ids);
                            })
                            ->sum('value');
            }

            $percent = ($sum / $total) * 100; 

            $service->percent = $percent;
            $service->installment_count = $count;

            $condition = ($count < $service->from_installment_id) || $percent < $service->installment_percent;

            if ($service->installment_percent > 0) {
                if ($condition) {
                    $valid = false;
                    $reason = __("The student did not pay the required percentage of the installment number ") . $service->from_installment_id;
                }
            }

            //$valid = false;
            //$reason =$total;
        }

        // check on student level
        if ($service->except_level_id && $valid) {
            if ($service->except_level_id == $student->level_id) {
                $valid = false;
                $reason = __("The service is not available for the student level");
            }
        }

        // check on student level
        if ($service->division && $valid) {
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
