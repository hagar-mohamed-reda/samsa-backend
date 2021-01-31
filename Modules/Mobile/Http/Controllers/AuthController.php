<?php

namespace Modules\Mobile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AccountSetting;
use Modules\Academic\Entities\Student;
use DB;

class AuthController extends Controller {

    /**
     * get analysis of main activities of mobile
     * 
     */
    public function login(Request $request) {
        $validator = validator($request->all(), [
            "username" => "required",
            "password" => "required"
        ]);
        
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first());
        }
        
        try {
            $student = Student::query()
                    ->where('username', $request->username)
                    ->orWhere('phone', $request->username)
                    ->where('password_', $request->password)
                    ->with(['level', 'department'])
                    ->first();
            
            if (!$student) {
                return responseJson(0, __('username or password error'));
            }
            
            $student->api_token = randToken();
            $student->update();
            
            return responseJson(1, __('done'), $student->refresh());
        } catch (\Exception $exc) {
            return responseJson(0, $exc->getMessage());
        }
    }

}
