<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderItemController extends Controller
{
    
    public function getPurchaseOrderItems(Request $request){
        $purchase_order_id = $request->purchase_order_id;
        $data = PurchaseOrderItem::where("purchase_order_id", $purchase_order_id)->get();
        return json_encode($data);
    }

    public function getPurchaseOrderPerSection(Request $request){
        $project_id = $request->project_id;
        $section_code = $request->section_code;

        // $purchase_orders = PurchaseOrder::where("project_id", $project_id)->where("project_order_items.section_code", $section_code);
        $purchase_orders = PurchaseOrder::where("project_id", $project_id)
                            ->whereHas("po_items", function($po_item) use ($section_code){
                                $po_item->where("section_code",$section_code);
                            })
                            ->get();
        dd($purchase_orders);
    }

}
