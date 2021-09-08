<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Agencie extends FormRequest
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
        $rule = [
            'name' => 'required|max:255',        
            'phn_no' => 'max:255',
            'description' => 'required',
            'address' => 'required',
        ];
        
        if (request()->route('agencie')->id) {
            $rule['email'] = ['required','email',Rule::unique('agencies')->ignore(request()->route('agencie')->id),'max:255'];
        }else{
            $rule['email'] = ['required|email|unique:agencies|max:255'];
        }
        return $rule;
    }
}
