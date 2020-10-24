<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\DiscountRequest;

class DiscountRequestController extends Controller
{

    public function __construct() {
        // permission
    }

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $query = DiscountRequest::with(['discountType', 'user']);

        if (request()->student_id > 0)
            $query->where('student_id', request()->student_id);

        return $query->latest()->get();
    }

    /**
     * DiscountRequest a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $resource = null;
        try {
            $validator = validator($request->all(), [
                "student_id" =>  "required",
                "discount_type_id" =>  "required",
                "reason" =>  "required",
                "student_affairs_notes" =>  "required",
            ]);
            if ($validator->failed()) {
                return responseJson(0, __('write some notes'));
            }
            $data = $request->all();
            $data['user_id'] = $request->user->id;
            $resource = DiscountRequest::create($data);
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
    public function update(Request $request, DiscountRequest $discountType) {
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(DiscountRequest $discountType) {
         
    }
}
