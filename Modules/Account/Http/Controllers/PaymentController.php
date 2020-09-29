<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Payment; 

class PaymentController extends Controller
{
 
    /**
     * return all data in json format
     * @return json
     */
    public function getPaymentReceipt(Request $request) {
        $payment = Payment::find($request->payment_id);
        return view('account::payment_receipt', compact("payment"));
    }
  
}
