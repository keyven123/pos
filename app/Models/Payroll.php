<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function payroll_lists()
    {
        return $this->hasMany('App\Models\PayrollList', 'payroll_id', 'id');
    }
}
