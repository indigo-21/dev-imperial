<?php

namespace App\Http\Controllers;

use App\Models\CostPlanItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostPlanItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CostPlanItem $costPlanItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CostPlanItem $costPlanItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CostPlanItem $costPlanItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostPlanItem $costPlanItem)
    {
        //
    }

    public function getItemsBySupplier(Request $request){
        $supplier_id = $request->supplier_id;
        $data = CostPlanItem::where("supplier_id", $supplier_id)->get();
        return json_encode($data);
    }
}
