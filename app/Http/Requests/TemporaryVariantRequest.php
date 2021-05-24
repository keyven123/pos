<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemporaryVariantRequest extends FormRequest
{
    public function rules()
    {
        return [
            'variation_name' => 'required',
            'variation_price' => 'required',
        ];
    }
}
