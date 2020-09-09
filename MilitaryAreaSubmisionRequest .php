<?php

namespace Modules\Military\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MilitaryAreaSubmisionRequest  extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'military_area_id' => 'required',
            'government_id' => 'required',
            'city_id' => 'required'
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
