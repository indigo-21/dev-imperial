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
                    <label for="supplier_id">Supplier</label>
                        <select id="supplier_id" class="form-control">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($for_po_suppliers as $for_po_supplier)
                                <option value="{{ $for_po_supplier->id }}">{{ $for_po_supplier->business_name }}
                                </option>
                            @endforeach
                        </select>
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
                        <span class="font-weight-bold mb-2">Purchase Order Line Items</span>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Item Code</th>
                                    <th>Description</th>
                                    <th>PO Number</th>
                                    <th>PO Amount</th>
                                    <th style="width:25%;">Invoice Number</th>
                                    <th style="width:25%;">Invoice Amount</th>
                                </tr>
                            </thead>

                            <tbody id="line-items-table-body">

                            </tbody>
                    </form>
                    </table>

                    <!-- ACTIONS -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" id="proceed-btn-from-tablelist" class="btn btn-success btn-sm ">
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

@endsection


@section('scripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const supplierSelect = document.getElementById("supplier_id");
            const tableContainer = document.getElementById("line-items-table-container");
            const tableBody = document.getElementById("line-items-table-body");
        
            tableContainer.style.display = "none";
        
            // Updated sample static data
            const sampleItems = [
                {
                    item: "2.08",
                    description: "Provide small plant and access staging's",
                    total: "310.00",
                    po_number: "PO-00001",
                    po_amount: "310.00"
                },
                {
                    item: "2.08",
                    description: "Provide small plant and access staging's",
                    total: "310.00",
                    po_number: "PO-00002",
                    po_amount: "250.00"
                },
                {
                    item: "2.09",
                    description: "Provide temporary site offices and meeting facilities",
                    total: "1,282.50",
                    po_number: "PO-00003",
                    po_amount: "950.00"
                },
                {
                    item: "2.10",
                    description: "Mobile communications",
                    total: "500",
                    po_number: "PO-00003",
                    po_amount: "300.00"
                }
            ];
        
            supplierSelect.addEventListener("change", function () {
                if (this.value) {
                    tableBody.innerHTML = "";
        
                    sampleItems.forEach((item, index) => {
                        tableBody.innerHTML += `
                            <tr>
                    
                                <td>${item.item}</td>
                                <td>${item.description}</td>
                                <td>${item.po_number}</td>
                                <td>${item.po_amount}</td>
                                <td>
                                   <input type="text" 
                                   class="form-control" 
                                   name="invoice_number[${index}]"
                                   placeholder="Enter invoice Number">
                                </td>
                                <td>
                                    <input type="text" 
                                   class="form-control" 
                                   name="invoice_number[${index}]"
                                   placeholder="Enter Invoice Amount">
                                </td>
                            </tr>
                        `;
                    });
        
                    tableContainer.style.display = "block";
                } else {
                    tableBody.innerHTML = "";
                    tableContainer.style.display = "none";
                }
            });
        });
        </script>
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/purchase-order.js') }}"></script>
@endsection
