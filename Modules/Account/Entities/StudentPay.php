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
        if ($request->payment_type == 'service')
            return "service";
        if ($student->is_old_installed)
            return "installment";
        if ($student->old_balance > 0)
            return "old_academic_year_expense";
        if ($student->is_current_installed)
            return "installment";
        if ($student->current_balance > 0)
            return "academic_year_expense";
    }

    /**
     * pay value
     */
    public static function pay(Request $request, $installment=null, $payments=[]) {
        $student = Student::find($request->student_id);
        $details = $student->getStudentBalance()->getCurrrentAcademicYearExpenseDetail();
        //$payments = [];
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

        else if ($type == 'service') {
            foreach($request->services as $item) {
                $service = Service::find($item['id']);
                if ($service) {
                    $total = $item['number'] * ($service->value + $service->additional_value);
                     $payment = Payment::addPayment([
                        "date" => date('Y-m-d'),
                        "value" => $total,
                        "model_type" => "service",
                        "model_id" => $service->id,
                        "user_id" => $request->user->id,
                        "store_id" => $service->store_id,
                        "student_id" => $student->id,
                        "service_count" => $item['number']
                    ]); 
                    $payments[] = $payment;
                    StudentService::create([
                        "service_id" => $service->id,
                        "student_id" => $student->id,
                    ]);
                }
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
            $payments[] = $payment;
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
                            "installment_type" => "new",
                            "student_id" => $student->id
                        ]);
                        $payments[] = $payment;

                        $installment->paid = 1;
                        $installment->update();



                        if ($remained > 0) {
                            $request->value = $remained;
                            return self::pay($request, $installment, $payments);
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
                    "installment_type" => "old",
                    "student_id" => $student->id
                ]);
                $payments[] = $payment;
                $installment->paid = 1;
                $installment->update();
            }
        }
        /*$payments =  Payment::query()
            ->where('date', date('Y-m-d'))
            ->where('student_id', $student->id)
            ->latest()
            ->get();*/

        return $payments;
    }


    public static function payRefund(Request $request) {
        $payment = Payment::find($request->payment_id);

        $refund = Payment::addRefund([
            "date" => date('Y-m-d'),
            "value" => $payment->value,
            "model_type" => "refund",
            "model_id" => $payment->id,
            "user_id" => $request->user->id,
            "store_id" => $payment->store_id,
            "student_id" => $payment->student_id
        ]);
        $payment->is_refund = 1;
        $payment->refund_id = $refund->id;
        $payment->update();

        return $refund;
    }


    public static function removePayment(Request $request) {
        $payment = Payment::find($request->payment_id);
        $pay = $payment;
        if ($payment) {
            $payment->store->updateStore($payment->value * -1);
            $payment->delete();
        }

        return $pay;
    }

}
