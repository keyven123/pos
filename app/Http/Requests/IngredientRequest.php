<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngredientRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'name' => ['required'],
            'unit' => 'required'
        ];
    }
}
