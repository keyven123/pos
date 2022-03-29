<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $guarded = [];

    public function cart_histories()
    {
        return $this->hasMany('App\Models\CartHistory', 'ref_no', 'ref_no');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
