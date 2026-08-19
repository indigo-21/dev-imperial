@extends('pages.projects.form')
@section('invoice-tab')

    <div id="purchase-order-form" class="mt-3" >
        <div class="card border">
            <div class="card-header">
                <strong>Invoice Details</strong>
            </div>

            <div class="card-body">

                <!-- LINE ITEMS -->
                <div id="line-items-container">
                    <div class="form-group supplier-content">
                    <label for="supplier_to_invoice">Supplier</label>
                        <select id="supplier_to_invoice" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($purchase_order_suppliers as $purchase_order_supplier)
                                <option value="{{ $purchase_order_supplier->supplier_id }}">{{ $purchase_order_supplier->supplier->business_name }}
                                </option>
                            @endforeach
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
                        <span class="font-weight-bold mb-2">Purchase Order Line Items</span>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:5%;">Item Code</th>
                                    <th>Description</th>
                                    <th style="width:10%;">PO Number</th>
                                    <th style="width:10%;">PO Amount</th>
                                    <th style="width:15%;">Invoice Number</th>
                                    <th style="width:15%;">Invoice Amount</th>
                                </tr>
                            </thead>

                            <tbody id="line-items-table-body">

                            </tbody>
                    </form>
                    </table>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" id="proceed-btn-from-invoice" class="btn btn-success btn-sm ">
                            Proceed
                        </button>
                        <button type="button" id="cancel-btn-from-invoice" class="btn btn-secondary btn-sm ml-2">
                            Cancel
                        </button>
                    </div>
                    </form>

                </div>


            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/invoice.js') }}"></script>
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/purchase-order.js') }}"></script>
@endsection
