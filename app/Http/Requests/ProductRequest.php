<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required',
            'name' => ['required', Rule::unique('products')->ignore($this->id)],
            'description' => 'required',
            'image' => 'sometimes',
            'barcode' => ['required', Rule::unique('products')->ignore($this->id)],
            'is_available' => 'required',
            'variation' => 'required',
            'price' => 'required_if:variation,false',
            'variation' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The Category field is required',
            'is_available.required' => 'This is required'
        ];
    }

}
