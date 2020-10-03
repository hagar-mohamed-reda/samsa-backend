<?php

namespace Modules\Account\Entities;
use Illuminate\Http\Request;


class StudentPay
{
    /**
     * detect the payment type if
     * ['academic_year_expense','service','installment','old_academic_year_expense']
     */
    public static function getPayType(Student $student, Request $request) {
        if ($student->is_old_installed)
            return "installment";
        if ($student->old_balance > 0)
            return "old_academic_year_expense";
        if ($student->is_current_installed)
            return "installment";
        if ($student->current_balance > 0)
            return "academic_year_expense";
        if ($request->services)
            return "service";
    }

    /**
     * pay value
     */
    public static function pay(Request $request, $installment=null) {
        $student = Student::find($request->student_id);
        $details = $student->getStudentBalance()->getCurrrentAcademicYearExpenseDetail();
        $payments = [];
        $type = self::getPayType($student, $request);

        if ($type == "academic_year_expense") {
            foreach($details as $detail) {
                $payment = Payment::addPayment([
                    "date" => date('Y-m-d'),
                    "value" => $detail->value,
                    "model_type" => "academic_year_expense",
                    "model_id" => $detail->id,
                    "user_id" => $request->user->id,
                    "store_id" => $detail->store_id,
                    "student_id" => $student->id
                ]);

                $data = [
                    "date" => date('Y-m-d'),
                    "value" => $detail->value,
                    "model_type" => "academic_year_expense",
                    "model_id" => $detail->id,
                    "user_id" => $request->user->id,
                    "store_id" => $detail->store_id,
                    "student_id" => $student->id
                ];
                $payments[] = $payment;
                $student->changeStudentCaseConstraint();
            }
        }

        else if ($type == "old_academic_year_expense") {
            // old balance store
            $store = AccountSetting::getOldBalanceStore();
            $payment = Payment::addPayment([
                "date" => date('Y-m-d'),
                "value" => $request->value,
                "model_type" => "old_academic_year_expense",
                //"model_id" => null,
                "user_id" => $request->user->id,
                "store_id" => $store->id,
                //"installment_id" => optional($installment)->id,
                "student_id" => $student->id
            ]);
        }

        else if ($type == "installment") {
            if ($student->is_current_installed) {
                if (!$installment)
                    $installment = $student->getStudentBalance()->getReadyInstallment('new');
                foreach($details as $detail) {
                    $paidValue = Payment::query()
                        ->where('model_type', 'academic_year_expense')
                        ->where('model_id', $detail->id)
                        ->where('student_id', $student->id)
                        ->sum('value');

                    if ($paidValue < $detail->value && $request->value > 0) {
                        $value = $request->value;
                        $remained = $request->value - $detail->value;
                        //
                        if ($request->value > $detail->value)
                            $value = $detail->value;

                        $payment = Payment::addPayment([
                            "date" => date('Y-m-d'),
                            "value" => $value,
                            "model_type" => "academic_year_expense",
                            "model_id" => $detail->id,
                            "user_id" => $request->user->id,
                            "store_id" => $detail->store_id,
                            "installment_id" => optional($installment)->id,
                            "student_id" => $student->id
                        ]);

                        $installment->paid = 1;
                        $installment->update();

                        if ($remained > 0) {
                            $request->value = $remained;
                            return self::pay($request, $installment);
                        }
                    }

                }
            }
            else {
                $installment = $student->getStudentBalance()->getReadyInstallment('old');
                // old balance store
                $store = AccountSetting::getOldBalanceStore();
                $payment = Payment::addPayment([
                    "date" => date('Y-m-d'),
                    "value" => $request->value,
                    "model_type" => "installment",
                    //"model_id" => null,
                    "user_id" => $request->user->id,
                    "store_id" => $store->id,
                    "installment_id" => optional($installment)->id,
                    "student_id" => $student->id
                ]);
                $installment->paid = 1;
                $installment->update();
            }
        }
        $payments =  Payment::query()
            ->where('date', date('Y-m-d'))
            ->where('student_id', $student->id)
            ->get();

        return $payments;
    }



}
