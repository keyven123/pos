<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [];
            case 'DELETE':
                return [];
            case 'POST':
                return [
                ];
            case 'PUT':
                return [
                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:3',
                    'designation_id' => 'required',
                    'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)], 
                    'username' => ['required', 'min:5', Rule::unique('users')->ignore($this->id)],
                    'password' => 'required_without:id',
                    'contact' => 'sometimes|min:10|max:10',
                    'date_hire' => 'sometimes',
                    'rate' => 'sometimes',
                ];
            default:
                break;
        }
        
    }
    public function messages()
    {
        return [
            'designation_id.required' => 'the Designation field is required',
            'password.required_without' =>  'The password field is required.'
        ];
    }
}
