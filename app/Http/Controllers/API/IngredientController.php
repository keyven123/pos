<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
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
            return Ingredient::where('name', 'like', "%$request->search%")
                -orderBy('name', 'ASC')
                ->paginate($itemsPerPage);
        }
        return Ingredient::orderBy('name', 'ASC')->paginate($itemsPerPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientRequest $request)
    {
        return $this->updateOrCreateService->create($request->validated(), '\App\Models\Ingredient', 'Ingredient');
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
    public function update(IngredientRequest $request, $id)
    {
        return $this->updateOrCreateService->update($request->validated(), '\App\Models\Ingredient', 'Ingredient', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->updateOrCreateService->delete($id, '\App\Models\Ingredient', 'Ingredient');
    }
}
