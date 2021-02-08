<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Tree; 
use Modules\Account\Entities\Payment;
use DB;

class IncomeController extends Controller
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
        
        if (request()->date_from && request()->date_to) {
            $query->whereBetween('date', [request()->date_from, request()->date_to]);
        }
        
        return $query->get();
    }
  
 
}
