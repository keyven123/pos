<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UpdateOrCreateService;
use App\Models\ConsumedStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsumedStockController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index()
    {
        
    }

    
    public function store(Request $request)
    {
        $consumed_stock = DB::table('cart_histories as ch')
            ->where('ref_no', $request->ref_no)
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
        $ref_no = $request->all();
        $data = array();
        foreach ($consumed_stock as $val) {
            $data = array_merge($data, array(
                'ingredient_id' => $val->ingredient_id,
                'ref_no' => $ref_no['ref_no'],
                'quantity' => $val->pc_quantity,
                'product_quantity' => $val->ch_quantity,
                'unit' => $val->unit,
                'status' => 1)
            );
            $this->updateOrCreateService->create($data, '\App\Models\ConsumedStock', 'Consumed Stock');
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
