<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollList extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function payroll()
    {
        return $this->belongsTo('App\Models\Payroll');
    }
}
