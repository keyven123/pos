<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemporaryVariantRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\TemporaryVariant;
use Illuminate\Http\Request;

class TemporaryVariantController extends Controller
{
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index()
    {
        return TemporaryVariant::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemporaryVariantRequest $request)
    {
        return $this->updateOrCreateService->create($request->validated(), "\App\Models\TemporaryVariant", "TemporaryVariant");
    }

    public function update(TemporaryVariantRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), "\App\Models\TemporaryVariant", "TemporaryVariant", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, "\App\Models\TemporaryVariant", "TemporaryVariant");
    }
}
