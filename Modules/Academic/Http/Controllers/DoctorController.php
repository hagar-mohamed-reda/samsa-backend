<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Academic\Entities\Doctor;
use Modules\Academic\Entities\DoctorLevel;
use Modules\Academic\Entities\DoctorPrerequsite;
use Modules\Account\Entities\AccountSetting;

class DoctorController extends Controller {

    /**
     * return list of doctors
     * @return Response
     */
    public function get() {
        return Doctor::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $resource = null;

        try {
            $validator = validator($request->all(), [
                'name' => "required", 
                'phone' => "required|unique:academic_doctors,phone," . $request->phone,
                'username' => "required|unique:academic_doctors,username," . $request->username,
                //'email' => "required|unique:academic_doctors,email," . $request->email,
                'password' => "required|min:8",
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }
             
            $data = $request->all(); 
            $resource = Doctor::create($data);
            
            foreach($request->levels as $level) {
                DoctorLevel::create([
                    "doctor_id" => $resource->id,
                    "level_id" => $level,
                    "academic_year_id" => AccountSetting::getCurrentAcademicYear()->id
                ]);
            }
  
            watch(__('create new doctor ') . $resource->name, "fa fa-user");
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
    public function update(Request $request, Doctor $resource) {
        try {
            $validator = validator($request->all(), [
                'name' => "required", 
                'phone' => "required|unique:academic_doctors,phone," . $request->phone,
                'username' => "required|unique:academic_doctors,username," . $request->username,
                //'email' => "required|unique:academic_doctors,email," . $request->email,
                'password' => "required",
            ]);

            if ($validator->failed()) {
                return responseJson(0, __('fill all required data'));
            }

            $data = $request->all();
            $resource->update($data); 

            // delete old 
            $resource->doctorLevels()->delete();
            
            // add new
            foreach($request->levels as $level) {
                DoctorLevel::create([
                    "doctor_id" => $resource->id,
                    "level_id" => $level,
                    "academic_year_id" => AccountSetting::getCurrentAcademicYear()->id
                ]);
            }
            watch(__('update doctor ') . $resource->name, "fa fa-user");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('done'), $resource);
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Doctor $resource) {
        if ($resource->can_delete) {
            watch(__('remove doctor ') . $resource->name, "fa fa-user");
            $resource->delete();
        }
        return responseJson(1, __('done'));
    }

}
