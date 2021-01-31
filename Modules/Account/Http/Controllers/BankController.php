<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Bank; 

class BankController extends Controller
{

    public function __construct() {
        // permission
    } 

    /**
     * return all data in json format
     * @return json
     */
    public function index() {
        $resources = Bank::latest()->get();
        return $resources;
    }
 
    /**
     * Bank a newly created resource in storage.
     * @param Request $request
     * @return Response
     */ 
    public function bank(Request $request) {
        $resource = null;
        try { 
              
            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [
                "name" =>  "required|unique:account_banks",  
                "init_balance" =>  "required", 
            ], [
                "name.unique" => __('name already exist'), 
                "init_balance.required" => __('fill all required data'), 
            ]);
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            $data = $request->all();
            $data['user_id'] = $request->user->id;
            $data['balance'] = $request->init_balance;
             
            $resource = Bank::create($data); 
            watch(__('add Bank ') . $resource->name, "fa fa-bank");
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
    public function update(Request $request, Bank $Bank) {
        try { 
            $Bank->update($request->all());
            watch(__('edit Bank ') . $Bank->name, "fa fa-bank");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $Bank->fresh());
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Bank $bank) { 
        try { 
            watch(__('remove Bank ') . $bank->name, "fa fa-bank"); 
            $bank->delete();
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        return responseJson(1, __('done'));
    }
}
