<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class patient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:255',
            'email'=>'required|max:255|email|unique:patients,email',
            'phone'=>'required|max:10',
            'hospital_id'=>'required',
            'department_id'=>'required',
        ];
    }
}
