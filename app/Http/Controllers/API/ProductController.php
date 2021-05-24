<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $updateOrCreateService;

    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function filterCategory(Request $request)
    {
        return DB::table('products')
            ->leftJoin('categories as c', 'c.id', '=', 'products.category_id')
            ->where('c.name', 'like', "%$request->search%")
            ->orderBy('products.name', 'ASC')
            ->get();
            
        // Product::with('category', 'variants')
        //     ->where('category.name', 'like', "%$request->search%")
        //     ->orderBy('name', 'ASC')
        //     ->get();
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Product::with('category', 'variants')
                ->where('name', 'like', "%$request->search%")
                ->orWhere('description', 'like', "%$request->search%")
                ->orWhere('barcode', 'like', "%$request->search%")
                ->orWhere('price', 'like', "%$request->search%")
                ->orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }

        return Product::with('category', 'variants')
            ->orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
    }
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        if ($request->image) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $path = '/images/category/'.$imageName;
            $request->image->move(public_path('/images/category'), $imageName);
            $data = [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'barcode' => $request->barcode,
                'price' => $request->price,
                'is_available' => $request->is_available,
                'variation' => $request->variation,
                'image' => $path
            ];
        }
        return $this->updateOrCreateService->create($data, '\App\Models\Product', 'Product');
    }
    public function show($id)
    {
        //
    }
    public function update(ProductRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\App\Models\Product', 'Product', $id);
    }
    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\Product', 'Product');
    }
}
