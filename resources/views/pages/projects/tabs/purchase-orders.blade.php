@extends('pages.projects.form')
@section('purchase-orders-tab')
    <div class="card-header d-flex justify-content-between align-items-center">
        <button id="create-po-btn" type="button" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> &nbsp; Create Purchase Order
        </button>
    </div>

    <div id="purchase-order-form" class="mt-3" style="display:none;">
        <div class="card border">
            <div class="card-header">
                <strong>Create Purchase Order</strong>
            </div>

            <div class="card-body">

                <!-- LINE ITEMS -->
                <div id="line-items-container">
                    <div class="form-group supplier-content">
                    <label for="supplier_id">Supplier</label>
                        <select id="supplier_id" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($for_po_suppliers as $for_po_supplier)
                                <option value="{{ $for_po_supplier->supplier_id }}">{{ $for_po_supplier->business_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label class="font-weight-bold mb-2">Line Items</label>

                    <div id="line-items-list">

                    </div>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" id="proceed-btn-from-checklist" class="btn btn-success btn-sm ">
                            Proceed
                        </button>
                        <button type="button" id="cancel-btn-from-checklist" class="btn btn-secondary btn-sm ml-2">
                            Cancel
                        </button>
                    </div>

                </div>

                <div id="line-items-table-container" class="mt-4">
                    <form action="{{ route('projects.purchase_order_upsert') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="project_reference" value="{{ $project->reference }}">
                        <input type="hidden" name="purchase_order_id" value="">
                        <input type="hidden" name="supplier_id" value="">
                        <label class="font-weight-bold mb-2">Purchase Order Line Items</label>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th width="120">Qty</th>
                                    <th width="150">Unit Price</th>
                                    <th width="150">Total</th>
                                </tr>
                            </thead>

                            <tbody id="line-items-table-body">

                            </tbody>
                    </form>
                    </table>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="proceed-btn-from-tablelist" class="btn btn-success btn-sm ">
                            Proceed
                        </button>
                        <button type="button" id="cancel-btn-from-tablelist" class="btn btn-secondary btn-sm ml-2">
                            Cancel
                        </button>
                    </div>
                    </form>

                </div>


            </div>
        </div>
    </div>

    <div class="card-body">

        <!-- TABLE: Existing Purchase Orders -->
        <div id="purchase-order-table">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th style="width:10%">PO Number</th>
                        <th>Supplier</th>
                        <th style="width:20%">Created By</th>
                        <th class="text-center" style="width:10%">View</th>
                        <th class="text-center" style="width:10%">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($purchase_orders->count())
                        @foreach ($purchase_orders as $purchase_order )
                            <tr>
                                <td>{{"PO-" . str_pad($purchase_order->id, 5, '0', STR_PAD_LEFT)}}</td>
                                <td>{{$purchase_order?->supplier->business_name ?? ""}}</td>
                                <td>{{$purchase_order->created_user->firstname}} {{$purchase_order->created_user->lastname}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary view-purchase-order" 
                                        data-purchase-order-id="{{$purchase_order->id}}"
                                        data-supplier-id="{{$purchase_order->supplier_id}}"  title="View"><i
                                                class="fas fa-eye"></i></button>

                                    <button class="btn btn-sm btn-outline-primary edit-purchase-order" 
                                        data-purchase-order-id="{{$purchase_order->id}}"
                                        data-supplier-id="{{$purchase_order->supplier_id}}"  title="Edit"><i
                                                class="fas fa-pen"></i></button>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchase-orders.pdf', $purchase_order->id) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-danger"
                                        title="PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                                </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">
                                No data result...
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/purchase-order.js') }}"></script>
@endsection
