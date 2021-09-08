<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class User extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Male', 'Female']),],
            'home_address' => ['required'],
            'dob' => ['required'],
            'profile_summary' => ['required'],
            'key_skills' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(request()->route('id')->id)],
            'password' => ['confirmed'],
            'password_confirmation' => ['required_with:password'],
        ];

        return $rule;
    }
}
