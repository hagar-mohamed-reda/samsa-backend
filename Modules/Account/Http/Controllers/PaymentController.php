<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Payment; 
use Modules\Account\Entities\AcademicYearExpenseDetail;

class PaymentController extends Controller
{
 
    /**
     * return all data in json format
     * @return json
     */
    public function getPaymentReceipt(Request $request) {
        $payment = Payment::find($request->payment_id);

        if ($payment->model_type == 'academic_year_expense') {
        	$service = optional(AcademicYearExpenseDetail::find($payment->model_id))->service_id;

        	if ($service == 9 || $service == 10 || $service == 11) {
        		$payment->about = 'رسوم تحويل - رسوم مقصه';
        		$value = Payment::where('student_id', $payment->student_id)->where('paper_id', $payment->student_id . "-1")->sum('value');
        		$payment->value = $value;

        		$payment->is_pr = true;
        	}
        }


        return view('account::payment_receipt', compact("payment"));
    }
  
}
