<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\CartHistory;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function getOrders(Request $request)
    {
        if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } else {
            $itemsPerPage = $request->itemsPerPage;
        }
        return Order::with('cart_histories', 'cart_histories.variant', 'cart_histories.product')
            ->where('status', '<=', 1)
            ->orderBy('id', 'ASC')
            ->paginate($itemsPerPage);
    }
    public function doneOrder(Request $request, $id)
    {
        DB::transaction(function() use ($request, $id) {
            Order::findOrFail($id)->update($request->all());
            CartHistory::where('ref_no', $request->ref_no)->update(['status' => $request->status]);
        });
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Order::with('user', 'cart_histories', 'cart_histories.variant', 'cart_histories.product')
                ->where('ref_no', 'like', "%$request->search%")
                ->orderBy('created_at', 'DESC')
                ->paginate($itemsPerPage);
        }
        return Order::with('user', 'cart_histories', 'cart_histories.variant', 'cart_histories.product')
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id, 'status' => 0]);
        return $this->updateOrCreateService->create($request->all(), '\App\Models\Order', 'Order');
    }

    public function updateOrder(Request $request)
    {
        $id = Order::where('ref_no', $request->ref_no)->first()->id;
        $request->merge(['id' => $id]);
        return $this->updateOrCreateService->update($request->all(), '\App\Models\Order', 'Order', $id);
    }

    public function update(Request $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\App\Models\Order', 'Order', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\Order', 'Order');
    }
}
