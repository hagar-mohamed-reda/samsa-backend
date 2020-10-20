<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Account\Entities\Student;
use Modules\Account\Entities\StudentBalance;
use Modules\Account\Entities\AcademicYearExpenseDetail;
use Modules\Account\Entities\AcademicYearExpense;
use Modules\Account\Entities\AccountSetting;
use Modules\Account\Entities\Payment;
use Modules\Account\Entities\Service;
use Modules\Account\Entities\Store;
use Modules\Account\Entities\DiscountRequest;

use App\User;
use DB;

class ReceiptController extends Controller
{

    public function getDiscountRequestReceipt(Request $request, DiscountRequest $resource) {
        return view("account::discount_request_receipt", compact('resource'));
    }

}
