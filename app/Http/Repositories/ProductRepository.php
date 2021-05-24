<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository 
{
    public function updateOrCreate($request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            if (!isset($id)) {
                return Product::create($request);
            }

            return Product::updateOrCreate(
                ['id' => $id], $request
            );
        });
    }
    public function deleteProduct($id)
    {
        return DB::transaction(function () use ($id) {
            return Product::findOrFail($id)->delete();
        });
    }
}