<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function total_hour()
    {
        return $this->hasOne('App\Models\TotalUserTime', 'user_id', 'user_id');
    }
}
