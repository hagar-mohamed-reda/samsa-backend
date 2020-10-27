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
use Modules\Divisions\Entities\Level;
use Modules\Divisions\Entities\Division;

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


    public function studentBalances(Request $request) {
        $response = [];
        $students = [];

        $query = Student::query()->with(['level', 'division', 'case_constraint', 'academicYear']);

        if ($request->levels) {
            $query->whereIn('level_id', $request->levels);
        }

        if ($request->divisions) {
            $query->whereIn('division_id', $request->divisions);
        }

        if ($request->case_constraints) {
            $query->whereIn('case_constraint_id', $request->case_constraints);
        }

        if ($request->student_id > 0) {
            $query->where('id', $request->student_id);
        }
        // prepare students
        $servicesTotal = 0;
        $academicYearExpensesTotal = 0;
        $graduationServiceTotal = 0;

        $levels = Level::all();
        foreach($levels as $level) { 
            $levelChartQuery = clone $query;
            $level->count = $levelChartQuery->where('level_id', $level->id)->count();
        }

        $divisions = Division::all();
        foreach($divisions as $item) { 
            $levelChartQuery = clone $query;
            $item->count = $levelChartQuery->where('division_id', $item->id)->count(); 
        }

        $caseConstraints = DB::table('case_constraints')->get();
        foreach($caseConstraints as $item) { 
            $levelChartQuery = clone $query;
            $item->count = $levelChartQuery->where('case_constraint_id', $item->id)->count(); 
        }

        foreach($query->latest()->get() as $student) {
            $servicesTotal += $student->services_total;
            $academicYearExpensesTotal += $student->academic_year_expense_total;
            $graduationServiceTotal += $student->graduation_service_total;
        }

        return [
            "details" => $query->latest()->get(),
            "services_total" => $servicesTotal, 
            "academic_year_expense_total" => $academicYearExpensesTotal,
            "graduation_service_total" => $graduationServiceTotal,
            "level_chart" => $levels, 
            "divisions_chart" => $divisions, 
            "case_constraints" => $caseConstraints, 

        ];
    }


    public function reportCreator(Request $request) {
        $response = [];
        $students = [];

        $query = Student::with(['level', 'division', 'case_constraint', 'academicYear'])
        ->select(
            '*'
        );

        if ($request->academic_years) {
            $query->whereIn('academic_years_id', $request->academic_years);
        }

        if ($request->levels) {
            $query->whereIn('level_id', $request->levels);
        }

        if ($request->divisions) {
            $query->whereIn('division_id', $request->divisions);
        }

        if ($request->case_constraints) {
            $query->whereIn('case_constraint_id', $request->case_constraints);
        }

        if ($request->registeration_status) {
            $query->whereIn('registration_status_id', $request->registeration_status);
        }

        if (count($request->acceptance) == 1) {
            if ($request->acceptance[0] == 'has_acceptance')
                $query->whereIn('acceptance_code', '!=', null);
            else
                $query->whereIn('acceptance_code', null);
        }

        if (count($request->acceptance) == 2) {
            //$query->whereIn('acceptance_code', '!=', null);
        }

        if ($request->student_id > 0) {
            $query->where('id', $request->student_id);
        }


        // prepare students
        $oldBalance = 0;
        $currentBalance = 0;
        $paids = 0;
        $refund = 0;
        $discount = 0;
        $remind = 0;


        foreach($query->get() as $item) {

            $valid = true;
            if ($request->is_current_balance == 'true') {
                if (!($item->current_balance >= $request->current_balance_from && $item->current_balance <= $request->current_balance_to)) {
                    $valid = false;
                }
            }
            if ($request->is_old_balance == 'true') {
                if (!($item->old_balance >= $request->old_balance_from && $item->old_balance <= $request->old_balance_to)) {
                    $valid = false;
                }
            }
            if ($request->is_paids == 'true') {
                if (!($item->paids >= $request->paids_from && $item->paids <= $request->paids_to)) {
                    $valid = false;
                }
            }
            if ($request->is_discount == 'true') {
                if (!($item->discount_total >= $request->discount_from && $item->discount_total <= $request->discount_to)) {
                    $valid = false;
                }
            }
            if ($request->is_refund == 'true') {
                if (!($item->refund_total >= $request->refund_from && $item->refund_total <= $request->refund_to)) {
                    $valid = false;
                }
            }
            if ($request->is_balance == 'true') {
                if (!($item->student_balance >= $request->balance_from && $item->student_balance <= $request->balance_to)) {
                    $valid = false;
                }
            }
            if ($valid)
                $students[] = $item;

            if ($valid) {
                $oldBalance += $item->old_balance;
                $currentBalance += $item->current_balance;
                $paids += $item->paids;
                $refund += $item->refund_total;
                $discount += $item->discount_total;
            }
        }

        $levels = Level::all();
        foreach($levels as $level) { 
            $levelChartQuery = clone $query;
            $level->count = $levelChartQuery->where('level_id', $level->id)->count();
        }

        $divisions = Division::all();
        foreach($divisions as $item) { 
            $levelChartQuery = clone $query;
            $item->count = $levelChartQuery->where('division_id', $item->id)->count(); 
        }
 

        $remind = ($paids - $discount);

        return [
            "details" => $students,
            "old_balance" => $oldBalance, 
            "current_balance" => $currentBalance,
            "paids" => $paids,
            "refund" => $refund,
            "discount" => $discount,
            "remind" => $remind,
            "old_balance_percent" => $currentBalance>0 ? ($oldBalance / $currentBalance) * 100 : 0,
            "current_balance_percent" => $currentBalance > 0?($oldBalance / $currentBalance) * 100 : 0,
            "level_chart" => $levels, 
            "divisions_chart" => $divisions 
        ];
    }


    public function studentInstallment(Request $request) {
        $response = [];
        $students = [];

        $query = Student::query()->with(['level', 'division', 'case_constraint', 'academicYear', 'installments'])
        ->select(
            '*',
            DB::raw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and date <= CURRENT_DATE and paid != 1) as required_installment_count'),
            DB::raw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and paid = 1) as paid_installment_count'),
            DB::raw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id) as installment_count'),
            DB::raw('(select sum(account_installments.value) from account_installments where account_installments.student_id = students.id) as installment_total')
        );

        $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id) > 0');

        $type = $request->type;
 
        if ($type == 'all_required_installment') {
            $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and date <= CURRENT_DATE and paid != 1) = 0');
        }
 
        if ($type == 'has_required_installment') {
            $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and date <= CURRENT_DATE and paid != 1) > 0');
        }

        if ($type == 'has_no_required_installment') {
            $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and paid != 1) = 0');
        }

        if ($type == 'has_installment') {
            $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id and paid != 1) > 0');
        }
 
        if ($type == 'all_installment') {
            $query->whereRaw('(select count(account_installments.id) from account_installments where account_installments.student_id = students.id) > 0');
        }

        return [
            "details" => $query->latest()->get()   
        ];
    }


    public function studentDiscounts(Request $request) {
        $response = [];
        $students = [];

        $query = Student::query()->with(['level', 'division', 'case_constraint', 'academicYear', 'discount_requests'])
        ->select(
            '*',
            DB::raw('(select count(account_discounts.id) from account_discounts where account_discounts.student_id = students.id) as discount_count'), 
        );

        $query->whereRaw('(select count(account_discounts.id) from account_discounts where account_discounts.student_id = students.id) > 0');
 

        return [
            "details" => $query->latest()->get()   
        ];
    }
}
