<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student as StudentOrigin;
use Modules\Card\Entities\CardType;
use Modules\Academic\Entities\Student as StudentAcademic;

use DB;

class Student extends StudentOrigin
{

    protected $table = "students";

    protected $appends = [
        'is_current_installed',
        'is_old_installed',
        'current_balance',
        'old_balance',
        'paid_value',
        'paids',
        'gpa',
        'services',
        'image',
        'can_convert_to_student',
        'payment_details',
        'old_balance_notes',
        'can_edit_old_balance',
        'current_balance_total',
        'refund_total',
        'discount_total',
        'can_create_discount_request',
        'last_discount_request',
        'services_total',
        'academic_year_expense_total',
        'graduation_service_total',
        'student_balance', 
        'available_cards'
    ];

    public function getAvailableCardsAttribute() {
        $cardTypes = DB::table('card_types')->pluck('id')->toArray();
        $cardExports = DB::table('card_exports')->where('student_id', $this->id)->pluck('payment_id')->toArray();
        $cardServices = DB::table('card_types')->pluck('service_id')->toArray();

        $payments = DB::table('account_payments')->where('student_id', $this->id)->where('model_type', 'service')->whereIn('model_id', $cardServices)->whereNotIn('id', $cardExports)->pluck('model_id')->toArray();

        $availableCards = CardType::whereIn('service_id', $payments)->get();

        return $availableCards;
    }

    public function getGraduationServiceTotalAttribute() {
        return Payment::where('student_id', $this->id)->where('model_type', 'service')->where('model_id', 2)->sum('value');
    }

    public function getServicesTotalAttribute() {
        return Payment::where('student_id', $this->id)->where('model_type', 'service')->sum('value');
    }

    public function getAcademicYearExpenseTotalAttribute() {
        return Payment::where('student_id', $this->id)
        ->whereIn('model_type', ['academic_year_expense', 'old_academic_year_expense'])
        ->sum('value');
    }

    public function getLastDiscountRequestAttribute() {
        return DB::table('account_discount_requests')->where('student_id', $this->id)->where('paid', '!=', '1')->latest()->first();
    }

    public function getCanCreateDiscountRequestAttribute() {
        return (DB::table('account_discount_requests')->where('student_id', $this->id)->where('paid', '!=', '1')->exists())? false : true;
    }

    public function getCodeAttribute() {
        return $this->id;
    }

    public function getStudentBalanceAttribute() {
        $balance = $this->current_balance_total;
        return $balance;
    }

    public function getDiscountTotalAttribute() {
        return DB::table('account_discounts')->where('student_id', $this->id)->sum('value');
    }

    public function getCanEditOldBalanceAttribute() {
        $can = true;
        if (Payment::where('model_type', 'old_academic_year_expense')->where('student_id', $this->id)->count() > 0) {
            $can = false;
        }

        if (Installment::where('type', 'old')->where('student_id', $this->id)->count() > 0) {
            $can = false;
        }

        return $can;
    }

    public function getOldBalanceNotesAttribute() {
        return optional(StudentOldBalance::where('student_id', $this->id)->first())->notes;
    }

    public function getPaymentDetailsAttribute() {
        $payments = [];
        foreach($this->payments()->get() as $payment) {
            if (!isset($payments[$payment->date]))
                $payments[$payment->date] = [ 'total' => 0, "payments" => [] ];


            $payments[$payment->date]['date'] = $payment->date;
            $payments[$payment->date]['total'] += $payment->value;
            $payments[$payment->date]['payments'][] = $payment;
        }
        $arr = [];
        foreach($payments as $key => $value) {
            $arr[] = $value;
        }

        return $arr;
    }


    public function getCanConvertToStudentAttribute() {
        $ids = DB::table("account_academic_year_expenses_details")->where('priorty', 1)->pluck('id')->toArray();
        $paymentCounts = DB::table('account_payments')
        ->where('model_type', 'academic_year_expense')
        ->where('student_id', $this->id)
        ->whereIn('model_id', $ids)->count();

        return $paymentCounts > 0? true : false;
    }

    public function getOldBalanceAttribute() {
        return $this->getStudentBalance()->getOldBalance();
    }

    public function getPaidValueAttribute() {
        return $this->getStudentBalance()->getPaidValue();
    }

    public function getCurrentBalanceTotalAttribute() {
        return $this->getStudentBalance()->getCurrentBalanceTotal();
    }

    public function getCurrentBalanceAttribute() {
        // $this->getStudentBalance()->getCurrentBalance();
        return $this->getStudentBalance()->getPaidValue();
    }

    public function getRefundTotalAttribute() {
        return $this->payments()->where('model_type', 'refund')->sum("value");
    }

    public function getPaidsAttribute() {
        return $this->payments()->where('model_type','!=', 'refund')->where(function($q) {
            if (request()->academic_year_expenses) {
                $ids = AcademicYearExpenseDetail::whereIn('service_id', request()->academic_year_expenses)->pluck('id')->toArray();
                $q->whereIn('model_id', $ids);
            }
        })->sum("value");
    }

    public function getGpaAttribute() {
        $student = new StudentAcademic();
        return $student->getGpa();
    }

    public function getServicesAttribute() {
        $ids = StudentService::where('student_id', $this->id)->pluck('service_id')->toArray();
        return Service::whereIn('id', $ids)->get();
    }

    public function getImageAttribute() {
        $studentImage = DB::table('students')->find($this->id);

        $path = $studentImage->personal_photo;
        return $path? url($path) : '/assets/img/avatar.png';
    }

    public function getStudentBalance() {
        return StudentBalance::find($this->id);
    }

    public function getIsCurrentInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'new')
                ->where('paid', '0')
                ->first();

        return $installment? true : false;
    }

    public function getIsOldInstalledAttribute() {
        $installment = DB::table('account_installments')
                ->where('student_id', $this->id)
                ->where('type', 'old')
                ->where('paid', '0')
                ->first();

        return $installment? true : false;
    }

    public function installments() {
        return $this->hasMany("Modules\Account\Entities\Installment", "student_id")->orderBy('date');
    }

    public function payments() {
        return $this->hasMany("Modules\Account\Entities\Payment", "student_id")->with(['store']);
    }

    public function balanceResets() {
        return $this->hasMany("Modules\Account\Entities\BalanceReset", "student_id")->with(['user']);
    }

    public function discount_requests() {
        return $this->hasMany("Modules\Account\Entities\DiscountRequest", "student_id")->with(['discountType', 'user']);
    }

    public function level() {
        return $this->belongsTo("Modules\Divisions\Entities\Level", "level_id")->select(['id', 'name']);
    }

    public function division() {
        return $this->belongsTo("Modules\Divisions\Entities\Division", "division_id")->select(['id', 'name']);
    }

    public function canGetService() {

    }

    public function getAvailableServices() {
        $ids = [];
        $services = Service::where('active', '1')->get();
		
        $availableServices = [];

        foreach ($services as $service) {
            $res = AccountSetting::canStudentGetService($service, $this);

            $service->valid = $res['valid'];
            $service->reason = $res['reason'];

            //$availableServices[] = $service;
            //if ($res['valid']) {
            //    $ids[] = $service->id;
            //}
        }

        return $services;//Service::whereIn('id', $ids)->get(['id', 'name', 'value', 'additional_value']);
    }

    public function changeStudentCaseConstraint() {
        if ($this->case_constraint_id == 1 && $this->can_convert_to_student) {
            $this->case_constraint_id = 2;
            $this->is_application = 0;
            $this->update();
        }
    }



}
