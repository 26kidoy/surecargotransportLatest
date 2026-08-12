<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:users|regex:/^09[0-9]{9}$/',
            'city' => 'required|in:cebu,bantayan,bacolod',
            'user_type' => 'required|in:poultry_owner,customer',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
        ];
    }

    public function messages()
    {
        return [
            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.unique' => 'This mobile number is already registered.',
            'mobile_number.regex' => 'Mobile number must be exactly 11 digits and start with 09 (e.g., 09123456789).',
            'city.required' => 'Please select your city.',
            'user_type.required' => 'Please select user type.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
        ];
    }
}