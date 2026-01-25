<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;

class PurchaseOrderItemController extends Controller
{
    
    public function getPurchaseOrderItems(Request $request){
        $purchase_order_id = $request->purchase_order_id;
        $data = PurchaseOrderItem::where("purchase_order_id", $purchase_order_id)->get();
        return json_encode($data);
    }

}
