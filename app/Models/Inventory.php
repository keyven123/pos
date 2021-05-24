<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    public function ingredient()
    {
        return $this->belongsTo('App\Models\Ingredient');
    }

    public function units()
    {
        return $this->belongsTo('App\Models\Ingredient');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function consumed_stocks()
    {
        return $this->hasMany('App\Models\ConsumedStock', 'ingredient_id', 'ingredient_id');
    }

}
