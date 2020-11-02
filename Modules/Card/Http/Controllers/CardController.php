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
    public function exportCard(Request $request)
    {
        try { 
             $validator = validator($request->all(), [
                "card_id" =>  "required",
                "payment_id" =>  "required",
                "student_id" =>  "required"
            ]);
            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
            $student = Student::with(['card_exports'])->find(request()->student_id);
            $card = CardType::find(request()->card_id);
            $payment = Payment::where('model_id', optional($card->service)->id)->where('model_type', 'service')->where('student_id', $request->student_id)->latest()->first(); 
 
            $errors = CardReason::getReasons($student, $card);

            // check on the reason of card
            if (!CardReason::canTakeCard($student, $card))
                return responseJson(0, implode("<br>", $errors));
 
  
            $data = $request->all();
            $data['date'] = date('Y-m-d');
            $data['payment_id'] = optional($payment)->id;

            $resource = CardExport::create($data);

            watch(__('add card for student'), "fa fa-picture-o");
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $e) {
            return responseJson(0, $e->getMessage());
        }
    }


    public function getCardReaderView() {
        return view('card::card_reader');
    }
   
}
