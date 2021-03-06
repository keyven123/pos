<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory');
    }

}
