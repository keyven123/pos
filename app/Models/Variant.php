<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $guarded = [];

    public function product()
    {
        return $this->BelongsTo('App\Models\Product');
    }
    public function cart_histories()
    {
        return $this->hasMany('App\Models\CartHistory');
    }
    public function product_components()
    {
        return $this->hasMany('App\Models\ProductComponent');
    }
}
