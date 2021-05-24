<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\CartHistory;
use App\Models\Ingredient;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function getAllHistory(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Inventory::with('ingredient', 'user')
                ->where('name', 'like', "%$request->search%")
                ->orderBy('created_at', 'DESC')
                ->paginate($itemsPerPage);
        }
        return Inventory::with('ingredient', 'user')
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Ingredient::withSum('inventories', 'quantity')
                ->where('name', 'like', "%$request->search%")
                ->orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }
        return Ingredient::withSum('inventories', 'quantity')
            ->withSum('consumed_stocks', 'quantity')
            ->orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
    }

    public function getCartComputation()
    {
        return DB::table('cart_histories as ch')
            ->leftJoin('variants as v', 'v.id', 'ch.variant_id')
            ->leftJoin('product_components as pc', 'pc.variant_id', 'v.id')
            ->leftJoin('ingredients as i', 'i.id', 'pc.ingredient_id')
            ->select('pc.quantity as pc_quantity',
                'pc.unit as unit',
                'ch.quantity as ch_quantity',
                'v.variation_name as variation_name',
                'i.name as ingredient_name',
                'i.id as ingredient_id'
            )
            ->get();
    }

    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $inventories = $request->all();
                foreach ($inventories as $inventory) {
                    $data = Inventory::create(
                        [
                        'user_id' => auth()->user()->id,
                        'ingredient_id' => $inventory['ingredient_id'],
                        'quantity' => $inventory['quantity']
                        ]
                    );
                }
                if ($data) {
                    return response()->json([
                        'success' => true,
                        'message' => "Inventories created successfully",
                        'alert_type' => 'success',
                        'data' => $data
                    ]);
                }
            });
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'alert_type' => 'error'
            ]);
        }
    }

    public function showSpecificInventory(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        }
        return Inventory::with('ingredient', 'user')
            ->where('ingredient_id', $request->id)
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
