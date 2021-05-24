<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class UpdateOrCreateRepository
{
    public function UpdateOrCreate($request, $model, $id = null)
    {
        // dd($request, $model, $id);
        return DB::transaction(function () use ($request, $model, $id) {
            return $model::updateOrCreate(
                ['id' => $id], $request
            );
        });
    }

    public function delete($id, $model)
    {
        return DB::transaction(function () use ($id, $model) {
            return $model::findOrFail($id)->delete();
        });
    }
}