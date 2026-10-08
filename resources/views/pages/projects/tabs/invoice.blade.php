@extends('pages.projects.form')
@section('invoice-tab')

    <!-- CREATE INVOICE BUTTON --> 
    <div class="card-header d-flex justify-content-between align-items-center"> 
        <button id="create-invoice-btn" type="button" class="btn btn-primary btn-sm"> 
        <i class="fas fa-plus"></i> &nbsp; Create Invoice </button> 
    </div>

    <div id="purchase-order-form" class="mt-3" style="display:none;">
        <div class="card border">
            <div class="card-header">
                <strong>Invoice Details</strong>
            </div>

            <div class="card-body">

                <!-- LINE ITEMS -->
                <div id="line-items-container">
                    <div class="form-group supplier-content">
                    <label for="purchase_order_to_invoice">Supplier</label>
                        <select id="purchase_order_to_invoice" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($purchase_orders as $purchase_order)
                                <option value="{{ $purchase_order->id }}">
                                    {{ 'PO-' . str_pad($purchase_order->id, 5, '0', STR_PAD_LEFT) }}
                                    - {{ $purchase_order->supplier->business_name }}
                                </option>
                            @endforeach
                            {{-- @foreach ($purchase_order_suppliers as $purchase_order_supplier)
                                <option value="{{ $purchase_order_supplier->supplier_id }}">{{ $purchase_order_supplier->supplier->business_name }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>

                <div id="line-items-table-container" class="mt-4">
                    <form action="{{ route('projects.purchase_order_upsert') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="project_reference" value="{{ $project->reference }}">
                        <input type="hidden" name="purchase_order_id" value="">
                        <input type="hidden" name="supplier_id" value="">

                        <div class="form-group">
                            <label for="invoice_number">Invoice Number</label>
                            <input
                                type="text"
                                id="invoice_number"
                                class="form-control"
                                placeholder="Enter invoice number"
                            >
                        </div>

                        <span class="font-weight-bold mb-2">Invoice Line Items</span>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:5%;">Item Code</th>
                                    <th>Description</th>
                                    <th style="width:10%;">PO Amount</th>
                                    <th style="width:15%;">Outstanding Amount</th>
                                    <th style="width:15%;">Invoice Amount</th>

                                </tr>
                            </thead>

                            <tbody id="line-items-table-body">

                            </tbody>
                    </table>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <div class="mt-3 text-right">
                            <button
                                type="button"
                                id="save-invoice-btn"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-save"></i>
                                Save Invoice
                            </button>
                        </div>
                        <button type="button" id="cancel-btn-from-invoice" class="btn btn-secondary btn-sm ml-2">
                            Cancel
                        </button>
                    </div>
                    </form>

                </div>


            </div>
        </div>
    </div>

    <div class="card-body">

        <div id="invoice-table">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Invoice Number</th>
                        <th style="width: 15%">PO Number</th>
                        <th>Supplier</th>
                        <th class="text-right" style="width: 20%">
                            Invoice Amount
                        </th>
                        <th style="width:10%">Action</th>

                    </tr>
                </thead>
    
                <tbody>
                    @if ($invoices->count())
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>
                            {{ $invoice['invoice_number'] }}
                        </td>
                
                        <td>
                            {{ $invoice['po_number'] }}
                        </td>
                
                        <td>
                            {{ $invoice['supplier'] }}
                        </td>
                
                        <td class="text-right">
                            ₱{{ number_format($invoice['invoice_amount'], 2) }}
                        </td>
                        <td>
                        <button
                            type="button"
                            class="btn btn-sm btn-primary view-invoice"
                            data-invoice-number="{{ $invoice['invoice_number'] }}"
                            data-po-number="{{ $invoice['po_number'] }}"
                            data-supplier="{{ $invoice['supplier'] }}"
                            data-items='@json($invoice["items"])'
                        >
                            View
                        </button>
                        </td>
                    </tr>
                @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">
                                No invoice records found...
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    
    </div>

    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title">
                        Invoice Details
                    </h5>
    
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Invoice Number:</strong>
                            <span id="modalInvoiceNumber"></span>
                        </div>
    
                        <div class="col-md-6">
                            <strong>PO Number:</strong>
                            <span id="modalPoNumber"></span>
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <strong>Supplier:</strong>
                        <span id="modalSupplier"></span>
                    </div>
    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-right">Invoice Amount</th>
                            </tr>
                        </thead>
    
                        <tbody id="invoiceItems">
                        </tbody>
    
                        <tfoot>
                            <tr>
                                <th class="text-right">
                                    Total
                                </th>
                                <th class="text-right" id="modalInvoiceTotal">
                                    ₱0.00
                                </th>
                            </tr>
                        </tfoot>
                    </table>
    
                </div>
    
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                        Close
                    </button>
                </div>
    
            </div>
        </div>
    </div>
    

@endsection


@section('scripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/invoice.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/purchase-order.js') }}"></script>

    <script>
        $(document).on('click', '.view-invoice', function () {
        
            console.log('View invoice clicked');
        
            const button = $(this);
        
            const invoiceNumber = button.attr('data-invoice-number');
            const poNumber = button.attr('data-po-number');
            const supplier = button.attr('data-supplier');
        
            let items = button.attr('data-items');
        
            console.log('Invoice:', invoiceNumber);
            console.log('Items:', items);
        
            try {
                items = JSON.parse(items);
            } catch (error) {
                console.error('Unable to read invoice items:', error);
                return;
            }
        
            $('#modalInvoiceNumber').text(invoiceNumber);
            $('#modalPoNumber').text(poNumber);
            $('#modalSupplier').text(supplier);
        
            let rows = '';
            let total = 0;
        
            items.forEach(function (item) {
        
                const amount = parseFloat(item.amount) || 0;
        
                total += amount;
        
                rows += `
                    <tr>
                        <td>${item.description ?? ''}</td>
                        <td class="text-right">
                            ₱${amount.toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })}
                        </td>
                    </tr>
                `;
            });
        
            $('#invoiceItems').html(rows);
        
            $('#modalInvoiceTotal').text(
                '₱' + total.toLocaleString('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        
            $('#invoiceModal').modal('show');
        });
        </script>
@endsection
