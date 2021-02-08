<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Tree; 
use Modules\Account\Entities\Payment;
use Modules\Account\Entities\Solfa;
use Modules\Account\Entities\Store;
use Modules\Account\Entities\Bank;
use DB;
use Carbon\Carbon;

class BalanceController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $query = Payment::with(['student'])
                //->whereIn('model_type', ['academic_year_expense', 'old_academic_year_expense'])
                ->where('store_id', request()->store_id);
                 
        $data = [];
        $store = Store::find(request()->store_id);
        
        if (!request()->date_from || !request()->date_to || !$store)
            return [];
        
        $date1 = Carbon::createFromFormat("Y-m-d", request()->date_from);
        $date2 = Carbon::createFromFormat("Y-m-d", request()->date_to);
        $days = $date1->diffInDays($date2);
        $balance = $store->init_balance;
        
        for($index = 1; $index <= $days; $index ++) {
            $date = Carbon::create(date('Y', strtotime($date1)), date('m', strtotime($date1)), $index)->toDateString();
            $q = clone $query;
            $incomes = $q->where('date', $date)->sum('value');
            $expenses = DB::table('account_dailies')
                    ->where('store_id', request()->store_id)
                    ->where('date', $date)->sum('value');
            $deposites = DB::table('account_transformations')
                    ->where('type', 'store_to_bank')
                    ->where('store_id', request()->store_id)
                    ->where('date', $date)->sum('value');
            $custodies = DB::table('account_custodies')
                    ->where('store_id', request()->store_id)
                    ->where('date', $date)->sum('value');
            $solfa = Solfa::query()
                    ->where('store_id', request()->store_id)
                    ->where('date', $date)
                    ->get()
                    ->pluck('remained')->toArray();
            $solfa = array_sum($solfa);
            $balance += $incomes - ($expenses + $deposites + $custodies + $solfa);
            
            $item = [
                "date" => $date,
                "incomes" => $incomes,
                "expenses" => $expenses,
                "deposites" => $deposites,
                "custodies" => $custodies,
                "solfa" => $solfa,
                "balance" => $balance,
            ];
            $data[] = $item;
        }
         
        
        return $data;
    }

    /**
     * return all data in json format
     * @return json
     */
    public function bankBalance() {
        $data = [];
        $bank = Bank::find(request()->bank_id);
        
        if (!request()->date_from || !request()->date_to || !$bank)
            return [];
        
        $date1 = Carbon::createFromFormat("Y-m-d", request()->date_from);
        $date2 = Carbon::createFromFormat("Y-m-d", request()->date_to);
        $days = $date1->diffInDays($date2);
        $balance = $bank->init_balance;
        
        for($index = 1; $index <= $days; $index ++) {
            $date = Carbon::create(date('Y', strtotime($date1)), date('m', strtotime($date1)), $index)->toDateString();
            $deposites = DB::table('account_transformations')
                    ->where('type', 'store_to_bank')
                    ->where('bank_id', request()->bank_id)
                    ->where('date', $date)->sum('value');
            $checks = DB::table('account_checks')
                    ->where('bank_id', request()->bank_id)
                    ->where('date', $date)->sum('value'); 
            $balance += $deposites - $checks;
            
            $item = [
                "date" => $date,
                "deposites" => $deposites,
                "checks" => $checks,
                "balance" => $balance,
            ];
            $data[] = $item;
        }
         
        
        return $data;
    }
  
 
}
