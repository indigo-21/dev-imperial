<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrderItem;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('pages.projects.invoice-receipts');

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
    public function store(Request $request, PurchaseOrderItem $purchaseOrderItem)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:255',
            'invoice_amount' => 'required|numeric|min:0',
        ]);
    
        Invoice::create([
            'purchase_order_item_id' => $purchaseOrderItem->id,
            'invoice_number' => $validated['invoice_number'],
            'invoice_amount' => $validated['invoice_amount'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('projects.invoices.show', $purchaseOrderItem)
            ->with('success', 'Invoice created successfully.');
    }

    public function storeMultiple(Request $request): JsonResponse
{
    $validated = $request->validate([
        'invoiceNumber' => [
            'required',
            'string',
            'max:255',
        ],

        'items' => [
            'required',
            'array',
            'min:1',
        ],

        'items.*.purchaseOrderItemId' => [
            'required',
            'integer',
            'exists:purchase_order_items,id',
        ],

        'items.*.invoiceAmount' => [
            'required',
            'numeric',
            'min:0',
        ],
    ]);

    try {
        $invoices = DB::transaction(function () use ($validated) {

            return collect($validated['items'])->map(function ($item) use ($validated) {

                return Invoice::create([
                    'purchase_order_item_id' => $item['purchaseOrderItemId'],
                    'invoice_number' => $validated['invoiceNumber'],
                    'invoice_amount' => $item['invoiceAmount'],
                    'created_by' => auth()->id(),
                ]);

            });
        });

        return response()->json([
            'success' => true,
            'message' => 'Invoice saved successfully.',
            'items' => $invoices,
        ]);

    } catch (Throwable $exception) {

        report($exception);

        return response()->json([
            'success' => false,
            'message' => 'Failed to save invoice.',
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrderItem $purchaseOrderItem)
    {
        $invoices = $purchaseOrderItem->invoices()->latest()->get();

        return view('pages.projects.invoice-receipts', compact(
            'purchaseOrderItem',
            'invoices'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
