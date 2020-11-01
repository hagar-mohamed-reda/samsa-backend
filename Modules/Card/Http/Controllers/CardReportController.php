<?php

namespace Modules\Card\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Student;
use Modules\Card\Entities\CardReason;
use Modules\Card\Entities\CardType;
use Modules\Card\Entities\CardExport;
use Modules\Account\Entities\Payment;
use DB;

class CardReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $query = CardExport::with(['student', 'card']) 
        ->join('students', 'students.id', '=', 'card_exports.student_id');
 
        if (request()->student_id > 0) {
            $query->where('student_id', request()->student_id);
        }

        if (request()->divisions) {
            $query->whereIn('division_id', request()->divisions);
        }

        if (request()->levels) {
            $query->whereIn('level_id', request()->levels);
        }

        if (request()->cards) {
            $query->whereIn('card_id', request()->cards);
        }

        $levels = DB::table('levels')->get();
        foreach ($levels as $item) {
            $cloneQuery = clone $query; 
            $item->count = $cloneQuery->where('level_id', $item->id)->count();
        }

        $divisions = DB::table('divisions')->get();
        foreach ($divisions as $item) {
            $cloneQuery = clone $query; 
            $item->count = $cloneQuery->where('division_id', $item->id)->count();
        }

        $cardTypes = DB::table('card_types')->get();
        foreach ($cardTypes as $item) {
            $cloneQuery = clone $query; 
            $item->count = $cloneQuery->where('card_id', $item->id)->count();
        }

        $cardTotal = 0;
        $totalQuery = clone $query;

        foreach ($totalQuery->get() as $item) {
            $cardTotal += optional(optional($item->card)->service)->value;
        }

        return [
            "details" => $query->latest('card_exports.created_at')->get(),
            "levels" => $levels,
            "divisions" => $divisions,
            "card_types" => $cardTypes,
            "card_total" => $cardTotal
        ];

    }
 

   
}
