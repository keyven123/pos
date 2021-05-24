<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory');
    }
    public function consumed_stocks()
    {
        return $this->hasMany('App\Models\ConsumedStock');
    }
}
