<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartHistoryRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\CartHistory;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartHistoryController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index()
    {
        return Order::select('ref_no', 'amount', 'updated_at')
            ->where('status', 0)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }
    public function showCart(Request $request)
    {
        return CartHistory::with('product', 'variant')
            ->where('ref_no', $request->ref_no)->get();
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $auth = auth()->user()->id;
                foreach ($request->all() as $item) {
                    CartHistory::create([
                        'user_id' => $auth,
                        'product_id' => $item['product_id'],
                        'variant_id' => $item['variant_id'],
                        'ref_no' => $item['ref_no'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'status' => 0,
                    ]);
                }
            });
            return response()->json([
                'alert_type' => "success",
                'sucess' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateCart(Request $request)
    {
        DB::transaction(function() use ($request) {
            foreach ($request->all() as $req) {
                CartHistory::where('id', $req['id'])->update($req);
            }
        });
    }

    public function update(Request $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\App\Models\CartHistory', 'Cart History', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\CartHistory', 'Cart History');
    }
}
