<?php

namespace App\Http\Controllers;

use App\Models\CostPlanItem;
use App\Models\PurchaseOrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostPlanItemController extends Controller
{
    public function getItemsBySupplier(Request $request){
        $supplier_id = $request->supplier_id;
        $data = CostPlanItem::where("supplier_id", $supplier_id)->get();
        return json_encode($data);
    }

    public function getItems(Request $request){
        $section_id = $request->section_id;
        $items = CostPlanItem::where("cost_plan_section_id", $section_id)->get();
        $po_items = PurchaseOrderItem::where("cost_plan_section_id", $section_id)->get();
        $data = [
                "cost_plan_items" => $items,
                "purchase_order_items" => $po_items
            ];
        return json_encode($data);
    }
}
