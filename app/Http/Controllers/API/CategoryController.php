<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
            return Category::where('name', 'like', "%$request->search%")
                ->orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }
        return Category::orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        if ($request->image) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $path = '/images/category/'.$imageName;
            $request->image->move(public_path('/images/category'), $imageName);
            $data = [
                'name' => $request->name,
                'image' => $path
            ];
        }
        return $this->updateOrCreateService->create($data, '\App\Models\Category', 'Category');
    }

    public function show($id)
    {
        //
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\App\Models\Category', 'Category', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\Category', 'Category');
    }
}
