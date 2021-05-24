<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\TemporaryVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariantController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index(Request $request)
    {
        return Variant::where('product_id', $request->product_id)
        ->orderBy('variation_name', 'ASC')
        ->get();
    }

    public function createVariants(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $variants = $request->variants;
                foreach ($variants as $var) {
                    Variant::create([
                        'product_id' => $request->id,
                        'variation_name' => $var['variation_name'],
                        'variation_price' => $var['variation_price'],
                    ]);
                }
            });
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function store(VariantRequest $request)
    {
        return $this->updateOrCreateService->create($request->validated(), '\App\Models\Variant', 'Variant');
    }

    public function show($id)
    {
        //
    }

    public function update(VariantRequest $request, $id)
    {
        return $this->updateOrCreateService->UpdateOrCreate($request->validated(), '\App\Models\Variant', 'Variant', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\Variant', 'Variant');
    }
}
