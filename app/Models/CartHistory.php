<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function variant()
    {
        return $this->belongSto('App\Models\Variant', 'variant_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
