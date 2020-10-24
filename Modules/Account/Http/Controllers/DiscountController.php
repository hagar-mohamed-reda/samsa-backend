<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Discount;
use Modules\Account\Entities\DiscountRequest;

class DiscountController extends Controller
{

    public function __construct() {
        // permission
    }

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $query = Discount::query();

        if (request()->student_id > 0)
            $query->where('student_id', request()->student_id);

        return $query->latest()->get();
    }

    /**
     * Discount a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $resource = null;
        try {
            $validator = validator($request->all(), [
                "student_id" =>  "required", 
                "value" =>  "required", 
            ]);
            if ($validator->failed()) {
                return responseJson(0, __('write some notes'));
            }
            $data = $request->all();
            $data['user_id'] = $request->user->id;
            $data['discount_request_id'] = $request->id;
            $resource = Discount::create($data);
            //
            $discountRequest = DiscountRequest::find($request->id);
            $discountRequest->update([ "paid" => '1' ]);
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Discount $discountType) {
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Discount $discountType) {
         
    }
}
