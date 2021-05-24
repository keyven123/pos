<?php

namespace App\Http\Services;

use App\Http\Repositories\UpdateOrCreateRepository;
use Spatie\Permission\Models\Permission;

class UpdateOrCreateService
{
    public function __construct(UpdateOrCreateRepository $updateOrCreateRepository)
    {
        $this->updateOrCreateRepository = $updateOrCreateRepository;
    }
    public function create($request, $model, $modelName)
    {
        return $this->updateOrCreate($request, $model, $modelName);
    }

    public function update($request, $model, $modelName, $id)
    {
        return $this->updateOrCreate($request, $model, $modelName, $id);
    }
    public function UpdateOrCreate($request, $model, $modelName, $id = null)
    {
        if (!isset($id)) {
            $data = $this->updateOrCreateRepository->updateOrCreate($request, $model);
        } else {
            $data = $this->updateOrCreateRepository->updateOrCreate($request, $model, $id);
        }

        if (!isset($data)) {
            return ResponseMessage::createFail($modelName);
        }
        
        if ($modelName == "Role") {
            $data->syncPermissions($request['permissions']);
        }
        return ResponseMessage::createSuccess($modelName, $data);
    }
    public function delete($id, $model, $modelName)
    {
        try {
            $data = $this->updateOrCreateRepository->delete($id, $model);
        } catch (\Exception $ex) {
            return ResponseMessage::deleteFail($modelName);
        }

        if (!isset($data)) {
            return ResponseMessage::deleteFail($modelName);
        }

        return ResponseMessage::deleteSuccess($modelName);
    }
}