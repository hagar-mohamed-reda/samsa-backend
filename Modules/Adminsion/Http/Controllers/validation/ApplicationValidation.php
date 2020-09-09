<?php

namespace Modules\Adminsion\Http\Controllers\validation;
 
use Illuminate\Http\Request; 
use Modules\Adminsion\Entities\ApplicationRequired; 
use Modules\Settings\Entities\RegisterationStatus;

class ApplicationValidation   {

    /**
     * validate on the application store
     * 
     * @param Request $request
     */
    public function validateOnRequest(Request $request) { 
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'qualification_id' => 'required',
            'national_id' => 'required',
            'registration_status_id' => 'required',
            'academic_years_id' => 'required', 
            'grade' => 'required', 
            'qualification_date' => 'required', 
            'qualification_types_id' => 'required',
        ], [
            "name.required" => __('name is required'),
            "qualification_id.required" => __('qualification is required'),
            "registration_status_id.required" => __('registration_status is required'),
            "national_id.required" => __('national_id is required'),
            "academic_years_id.required" => __('academic_years is required'), 
            "grade.required" => __('grade is required'),
            "qualification_date.required" => __('qualification_date is required'),
            "qualification_types_id.required" => __('qualification_types is required'),
        ]);
        
        if ($validator->fails()) {
            return [
                "status" => 0,
                "message" => implode("<br>", $validator->errors()->all())
            ];
        }
        
        return [
            "status" => 1,
            "message" => ''
        ];
    }
    
    /**
     * validate on application required fields
     * 
     * @param Request $request
     * @return array
     */ 
    public function validateOnApplicationRequired(Request $request) {
        $requireds = [];
        $requiredsMessage = [];
        
        foreach(ApplicationRequired::all() as $item) {
            if ($item->required == 1) {
                $requireds[$item->name] = 'required';
                $requiredsMessage[$item->name . ".required"] = $item->display_name . " " . __('required'); 
            }
        }
        $validator = validator()->make($request->all(), $requireds, $requiredsMessage);
         
        if ($validator->fails()) {
            return [
                "status" => 0,
                "message" => implode("<br>", $validator->errors()->all())
            ];
        }
        
        return [
            "status" => 1,
            "message" => ''
        ];
    }

    /**
     * validate on registeration status and it's required documents
     * 
     * 
     * @param Request $request
     */
    public function validateOnRegisterationStatusDocument(Request $request) {
        $registerationStatus = RegisterationStatus::find($request->registration_status_id);
        
        $requireds = [];
        $requiredsMessage = [];
        
        foreach($registerationStatus->requiredDocuments()->get() as $item) { 
            $requireds['required_document_'. $item->id] = 'required';
            $requiredsMessage['required_document_'. $item->id . ".required"] = $item->name . " " . __('required');  
        }
        $validator = validator()->make($request->all(), $requireds, $requiredsMessage);
          
        if ($validator->fails()) {
            return [
                "status" => 0,
                "message" => implode("<br>", $validator->errors()->all())
            ];
        }
        
        return [
            "status" => 1,
            "message" => ''
        ];
        
        
    }

    
    /**
     * validate on registeration status field
     * 
     * @param Request $request
     */
    public function validateOnRegisterationStatusField(Request $request) { 
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'qualification_id' => 'required',
            'national_id' => 'required',
            'registration_status_id' => 'required',
            'academic_years_id' => 'required', 
            'grade' => 'required', 
            'qualification_date' => 'required', 
            'qualification_types_id' => 'required',
        ], [
            "name.required" => __('name is required'),
            "qualification_id.required" => __('qualification is required'),
            "registration_status_id.required" => __('registration_status is required'),
            "national_id.required" => __('national_id is required'),
            "academic_years_id.required" => __('academic_years is required'), 
            "grade.required" => __('grade is required'),
            "qualification_date.required" => __('qualification_date is required'),
            "qualification_types_id.required" => __('qualification_types is required'),
        ]);
        
        if ($validator->fails()) {
            return [
                "status" => 0,
                "message" => implode("<br>", $validator->errors()->all())
            ];
        }
        
        return [
            "status" => 1,
            "message" => ''
        ];
    }
}
