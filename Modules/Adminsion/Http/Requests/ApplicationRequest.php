<?php

namespace Modules\Adminsion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required',
            'address' => 'required',
            'birth_address' => 'required',
            'national_id' => 'required',
            'national_id_date' => 'required',
            'national_id_place' => 'required',
            'triple_number' => 'required',
            'registeration_date' => 'required',
            'military_area_id' => 'required',
            'military_status_id' => 'required',
            'academic_years_id' => 'required',
            'qualification_date' => 'required',
            'qualification_set_number' => 'required',
            'qualification_types_id' => 'required',
            'country_id' => 'required',
            'religion' => 'required',
            'government_id' => 'required',
            'city_id' => 'required',
            'language_1_id' => 'required',
            'language_2_id' => 'required',
            'gender' => 'required',
            'level_id' => 'required',
            'parent_job_id' => 'required',
            'nationality_id' => 'required',
            'parent_name' => 'required',
            'parent_national_id' => 'required',
            'parent_address' => 'required',
            'parent_phone' => 'required',
            'password' => 'required',
            'grade' => 'required',
            'phone_1' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
