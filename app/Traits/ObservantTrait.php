<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ObservantTrait
{
    public static function boot()
     {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            $model->created_by = $user->id ?? null;
            $model->updated_by = $user->id  ?? null;
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });       
    }
}
