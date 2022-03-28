<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
            return Role::with('permissions')
                ->where('name', 'like', "%$request->search%")
                ->orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }

        return Role::with('permissions')
            ->orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
    }

    public function store(RoleRequest $request)
    {
        $role = $this->updateOrCreateService->create($request->validated(), '\Spatie\Permission\Models\Role', 'Role');

        if ($role) {
            Designation::create([
                'name' => $request->name, 
            ]);
        }
        return $role;
    }

    public function show($id)
    {
        //
    }

    public function update(RoleRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\Spatie\Permission\Models\Role', 'Role', $id);
    }

    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\Spatie\Permission\Models\Role', 'Role');
    }
}
