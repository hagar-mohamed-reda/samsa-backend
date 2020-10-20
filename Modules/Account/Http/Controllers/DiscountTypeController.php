<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\DiscountType;

class DiscountTypeController extends Controller
{

    public function __construct() {
        // permission
    }

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        return DiscountType::latest()->get();
    }

    /**
     * DiscountType a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $resource = null;
        try {

            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [
                "name" =>  "required|unique:account_discount_types",
            ], [
                "name.unique" => __('name already exist'),
                "name.required" => __('fill all required data')
            ]);

            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            $data = $request->all();

            $resource = DiscountType::create($data);
            watch(__('add discount_type ') . $resource->name, "fa fa-percent");
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
    public function update(Request $request, DiscountType $discountType) {
        try {
            $discountType->update($request->all());
            watch(__('edit discount_type ') . $discountType->name, "fa fa-percent");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $discountType->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(DiscountType $discountType) {
        try {
            if ($discountType->can_delete) {
                watch(__('remove discount_type ') . $discountType->name, "fa fa-percent");
                $discountType->delete();
            }
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
