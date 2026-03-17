<?php

namespace App\Http\Controllers;
use App\Models\CostPlanSection;
use App\Models\CostPlanItem;
use App\Models\PurchaseOrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostPlanItemController extends Controller
{
    public function getItemsBySupplier(Request $request){
        $project_id = $request->project_id;
        $supplier_id = $request->supplier_id;

        // $data = CostPlanItem::where("supplier_id", $supplier_id)->get();
        // SELECT * FROM cost_plan_sections as cps LEFT JOIN cost_plan_items as cpi 
        //     ON cps.id = cpi.cost_plan_section_id WHERE cps.project_id = 2 AND FIND_IN_SET(12, cpi.supplier_id)
        $data = CostPlanSection::from('cost_plan_sections as cps')
                ->leftJoin('cost_plan_items as cpi', 'cps.id', '=', 'cpi.cost_plan_section_id')
                ->where('cps.project_id', $project_id)
                ->whereRaw('FIND_IN_SET(?, cpi.supplier_id)', [$supplier_id])
                ->select('cpi.*')
                ->get();
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
