<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => 'required',
            'payroll_start' => 'required',
            'payroll_end' => 'required'
        ];
    }
}
