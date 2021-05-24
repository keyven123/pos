<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Product;
use App\Models\ProductComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductComponentController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Product::with('product_components', 'product_components.variant', 'product_components.product', 'variants')
                ->where('name', 'like', "%$request->search%")
                ->orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }
        return Product::with('product_components', 'product_components.variant', 'product_components.ingredient', 'product_components.product', 'variants')
            ->orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
    }

    public function store(Request $request)
    {
        try {
            $data = array();
            foreach ($request->all() as $val) {
                $data = array_merge($data, array(
                    'product_id' => $val['product_id'],
                    'ingredient_id' => $val['ingredient_id'],
                    'variant_id' => $val['variant_id'],
                    'unit' => $val['unit'],
                    'quantity' => $val['quantity'])
                );
                $this->updateOrCreateService->create($data, '\App\Models\ProductComponent', 'Product Component');
            }
            return response()->json([
                'alert_type' => 'success',
                'message' => 'Product component successfully added',
                'success' => true 
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => 'Product component failed to submit',
                'success' => false 
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        try {
            foreach ($request->all() as $val) {
                
                if ($val['id']) {
                    $data = array();
                    $data = array_merge($data, array(
                        'id' => $val['id'],
                        'product_id' => $val['product_id'],
                        'ingredient_id' => $val['ingredient_id'],
                        'variant_id' => $val['variant_id'],
                        'unit' => $val['unit'],
                        'quantity' => $val['quantity'])
                    );
                    $this->updateOrCreateService->update($data, '\App\Models\ProductComponent', 'Product Component', $data['id']);
                } else {

                    // dd($val['product_id']);
                    $data = array();
                    $data = array_merge($data, array(
                        'product_id' => $val['product_id'],
                        'ingredient_id' => $val['ingredient_id'],
                        'variant_id' => $val['variant_id'],
                        'unit' => $val['unit'],
                        'quantity' => $val['quantity'])
                    );
                    $this->updateOrCreateService->create($data, '\App\Models\ProductComponent', 'Product Component');
                }
            }
            return response()->json([
                'alert_type' => 'success',
                'message' => 'Product component successfully added',
                'success' => true 
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => 'Product component failed to submit',
                'success' => false 
            ]);
        }
    }

    public function updateComponentIndividual(Request $request, $id)
    {
        return $this->updateOrCreateService->update($request->all(), '\App\Models\ProductComponent', 'Product Component', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\ProductComponent', 'Product Component');
    }
}
