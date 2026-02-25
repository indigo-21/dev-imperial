<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderItemController extends Controller
{
    
    public function getPurchaseOrderItems(Request $request){
        $purchase_order_id = $request->purchase_order_id;   
        $purchase_order_items = PurchaseOrderItem::where("purchase_order_id", $purchase_order_id)->get();
        $purchase_order = PurchaseOrder::find($purchase_order_id);
        $data = [
                    "purchase_order" => $purchase_order, 
                    "purchase_order_items" => $purchase_order_items
                ];
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

    public function generatePdf($id)
    {
        $purchaseOrder = PurchaseOrder::with('po_items', 'supplier')
        ->findOrFail($id);

        $project_reference = "PRJ-" . str_pad($purchaseOrder->project_id, 5, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('pdf.purchase-order', compact('purchaseOrder', 'project_reference'))
        ->setPaper('a4', 'portrait');

        return $pdf->stream('purchase-order-'.$purchaseOrder->id.'.pdf');
    }

}
