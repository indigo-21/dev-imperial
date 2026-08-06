<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Http\JsonResponse;

class PurchaseOrderItemController extends Controller
{

    public function getPurchaseOrderItems(Request $request)
    {
        $projectId = $request->projectId;
        $supplierId = $request->supplierId;
        $purchaseOrderId = $request->purchaseOrderId;

        $query = PurchaseOrder::where('project_id', $projectId)
            ->where("supplier_id", $supplierId);
        if ($purchaseOrderId) {
            $query->where('id', $purchaseOrderId);
        }

        $purchaseOrders = $query->get();

        $result = [];

        foreach ($purchaseOrders as $po) {
            $poNumber = 'PO-' . str_pad($po->id, 5, '0', STR_PAD_LEFT);

            foreach ($po->po_items as $item) {
                array_push($result, $item);
            }
        }

        return response()->json($result);
    }

    public function getPurchaseOrderPerSection(Request $request)
    {
        $project_id = $request->project_id;
        $section_code = $request->section_code;

        // $purchase_orders = PurchaseOrder::where("project_id", $project_id)->where("project_order_items.section_code", $section_code);
        $purchase_orders = PurchaseOrder::where("project_id", $project_id)
            ->whereHas("po_items", function ($po_item) use ($section_code) {
                $po_item->where("section_code", $section_code);
            })
            ->get();
        // dd($purchase_orders);
    }

    public function invoicedItems(Request $request): JsonResponse
    {
        $validatedItems = $request->validate([
            '*.purchaseOrderId' => [
                'required',
                'integer',
                'exists:purchase_order_items,id',
            ],
            '*.invoiceNumber' => [
                'nullable',
                'string',
                'max:255',
            ],
            '*.invoiceAmount' => [
                'nullable',
                'required_with:*.invoiceNumber',
                'numeric',
                'min:0',
            ],
        ]);

        try {
            $items = DB::transaction(function () use ($validatedItems) {
                return collect($validatedItems)
                    ->filter(
                        fn(array $item) => filled($item['invoiceNumber'] ?? null)
                    )
                    ->map(function (array $item) {
                        $purchaseOrderItem = PurchaseOrderItem::findOrFail(
                            $item['purchaseOrderId']
                        );

                        $purchaseOrderItem->invoice_number = $item['invoiceNumber'];
                        $purchaseOrderItem->invoice_amount = $item['invoiceAmount'];
                        $purchaseOrderItem->save();

                        return $purchaseOrderItem->fresh();
                    })
                    ->values();
            });

            return response()->json([
                'success' => true,
                'message' => $items->isEmpty()
                    ? 'No invoices were submitted.'
                    : 'Invoices saved successfully.',
                'items' => $items,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save invoices.',
            ], 500);
        }
    }

    public function generatePdf($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        $project_reference = "PRJ-" . str_pad($purchaseOrder->project_id, 5, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('pdf.purchase-order', compact('purchaseOrder', 'project_reference'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('purchase-order-' . $purchaseOrder->id . '.pdf');
    }
}
