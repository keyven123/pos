<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;
    protected $guarded = [];

    public function payroll_lists()
    {
        return $this->hasMany('App\Models\PayrollList', 'payroll_id', 'id');
    }
}
