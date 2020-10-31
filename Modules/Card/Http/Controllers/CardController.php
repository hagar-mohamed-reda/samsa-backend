<?php

namespace Modules\Card\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Student;
use Modules\Card\Entities\CardReason;
use Modules\Card\Entities\CardType;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $student = Student::with(['card_exports'])->find(request()->student_id);
        $card = CardType::find(request()->card_id);

        return [
            "can_take_card" => CardReason::canTakeCard($student, $card),
            "reason" => CardReason::getReasons($student, $card),
            "student" => $student
        ];
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('card::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('card::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('card::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
