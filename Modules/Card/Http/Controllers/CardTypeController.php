<?php

namespace Modules\Card\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Card\Entities\CardType;
use Modules\Account\Entities\Student;

class CardTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return CardType::with(['service'])->get();
    }
 

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function show(CardType $resource)
    {
        $student = Student::find(request()->student_id);
        return view("card::card." . $resource->id, compact("student"));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try { 
            $resource = CardType::create($request->all());
            watch(__('add card type'), "fa fa-card");
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $e) {
            return responseJson(0, $e->getMessage());
        }
    }
 
 

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $resource)
    {
        try { 
            $resource->update($request->all());
            watch(__('update card type'), "fa fa-card");
            return responseJson(1, __('done'), $resource);
        } catch (\Exception $e) {
            return responseJson(0, $e->getMessage());
        }
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
