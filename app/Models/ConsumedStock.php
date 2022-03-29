<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumedStock extends Model
{
    use HasFactory, ObservantTrait;

    protected $guarded = [];

}
