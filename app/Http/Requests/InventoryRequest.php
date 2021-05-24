<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ingredient_id' => 'required',
            'quantity' => 'required'
        ];
    }
}
