<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Http\Services\UpdateOrCreateService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function allPermission()
    {
        return Permission::all();
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Permission::where('name', 'like', "%$request->search%")
                ->paginate($itemsPerPage);
        }
        return Permission::paginate($itemsPerPage);
    }

    public function store(PermissionRequest $request)
    {
        return $this->updateOrCreateService->create($request->validated(), '\Spatie\Permission\Models\Permission', 'Permission');
    }

    public function show($id)
    {
        //
    }

    public function update(PermissionRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\Spatie\Permission\Models\Permission', 'Permission', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\Spatie\Permission\Models\Permission', 'Permission');
    }
}
