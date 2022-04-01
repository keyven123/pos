<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
                    'value' => 'required'
                ];
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'value.required' => 'The updated value is required.',
        ];
    }
}
