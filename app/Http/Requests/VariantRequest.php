<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => 'required',
            'variation_name' => 'required',
            'variation_price' => 'required'
        ];
    }
}
