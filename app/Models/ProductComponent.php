<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductComponent extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function variant()
    {
        return $this->belongsTo('App\Models\Variant');
    }
    public function ingredient()
    {
        return $this->belongsTo('App\Models\Ingredient');
    }

}
