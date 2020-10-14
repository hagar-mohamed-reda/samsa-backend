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
use Modules\Account\Entities\StudentPay;

use App\User;
use DB;

class ReportController extends Controller
{
 
    public function paymentDetails(Request $request) {
        $response = [];
        $query = Payment::query()->join("students", "students.id", "=", "student_id")
        ->where('academic_year_id', 1);

        if ($request->date_from && $request->date_to) {
            $query->whereBetween('date', [$request->date_from, $request->date_to]);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->model_type) {
            $query->where('model_type', $request->model_tpe);

            $query->where(function ($q) use ($request){
                $q->where("model_type", $request->model_type);

                if ($request->model_type == 'academic_year_expense')
                    $q->orWhere('installment_type', 'new');
                if ($request->model_type == 'old_academic_year_expense')
                    $q->orWhere('installment_type', 'old');
            });
        }

        if ($request->level_id > 0) {
            $query->whereIn("level_id", $request->level_id);
        }

        if ($request->division_id > 0) {
            $query->whereIn("division_id", $request->division_id);
        }

        if ($request->academic_year_id > 0) {
            $query->whereIn("academic_year_id", $request->academic_year_id);
        }

        if ($request->academic_year_expenses) {
            $ids = AcademicYearExpenseDetail::whereIn('service_id', $request->academic_year_expenses)->pluck('id')->toArray();  
            $query->where(function ($q) use ($request, $ids){
                $q->whereIn("model_id", $ids);
                $q->where("model_type", "academic_year_expense");
            });
        }

        if ($request->services) {  
            $query->where(function ($q) use ($request){
                $q->whereIn("model_id", $request->services);
                $q->where("model_type", "service");
            });
        }

        if ($request->payment_type == "out") {
            $query->where('model_type', "!=", "refund");
        }
        if ($request->payment_type == "in") {
            $query->where('model_type', "refund");
        }

        $totalQuery = clone $query;
        $query2 = clone $query;
        $query3 = clone $query;
        $query4 = clone $query;

        $serviceTotals = [];
        $academicYearExpensesTotal = [];

        foreach(Service::all() as $item) {
            $serviceQuery = clone $query; 
            $sum = $serviceQuery->where('model_type', 'service')->where('model_id', $item->id)->sum('value'); 
            $serviceTotals[$item->id] = $sum;
        }

        foreach(Service::where('is_academic_year_expense', '1')->get() as $item) {
            $expenseQuery = clone $query;  
            $ids = AcademicYearExpenseDetail::where('service_id', $item->id)->pluck('id')->toArray(); 
            $sum = $expenseQuery->where('model_type', 'academic_year_expense')->whereIn('model_id', $ids)->sum('value'); 
            $academicYearExpensesTotal[$item->id] = $sum;
        }

        $resources = $query->get();
        $totalWzValue = 0;

        foreach($resources as $resource) {
            $resource->wz_value = optional($resource->model_object)->wz_value;
            if (optional($resource->model_object)->wz_value) {
                $resource->value = $resource->value - optional($resource->model_object)->wz_value;
                $totalWzValue += optional($resource->model_object)->wz_value;
            } 
        }
 
        return [
            "details" => $resources,
            "services" => $serviceTotals,
            "academic_year_expense" => $academicYearExpensesTotal,
            "total" => $totalQuery->sum('value'),
            "payments_incomes" => $query2->where('model_type', "!=", "refund")->sum('value'),
            "payments_returns" => $query3->where('model_type', "refund")->sum('value'),
            "student_services" => $query4->where('model_type', "service")->sum('value'),
            "additional_value" => $totalWzValue
        ]; 
        //return ;//["*", "id as account_payments.id"]

    }

}
