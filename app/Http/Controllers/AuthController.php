<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CityRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\LoginHistory;

class AuthController extends Controller
{
    public function __construct()
    { 

    }

    public function login(Request $request) {
        $resource = null;
        try { 
              
            //return dump(toClass($data)->api_token);
            $validator = validator($request->json()->all(), [ 
                "email" =>  "required",  
                "password" =>  "required" 
            ], [
                "email.unique" => __('name already exist'),
                "password.required" => __('fill all required data')  
            ]);
            
            if ($validator->fails()) {
                return responseJson(0, $validator->errors()->first());
            }
            $data = $request->all(); 

            $user = User::where('email', $request->email)->where('password', $request->password)->first();

            if (!$user)
                return responseJson(0, __('email or password error'));
              
            if (!$user->api_token) {
                $user->api_token = time();
                $user->update();
            }
            
            $resource = $user->fresh();
            LoginHistory::create([
                'ip' => $request->ip(),
                'phone_details' => LoginHistory::getInfo($request),
                'user_id' => $user->id,
            ]);

        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }
        
        return responseJson(1, __('done'), $resource);
    }


    public getProfile(Request $request) {
        $profile = [];
        $profile['user'] = $request->user;
        $profile['notifications'] = $request->user->notifications()->get();
        $profile['loginHistory'] = $request->user->loginHistory()->get();

        // 
        return responseJson(1, $profile);
    }

    
}
