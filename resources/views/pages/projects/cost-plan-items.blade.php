<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>

    <x-slot name="pageTitle">
        Cost Plan Items
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <div class="col-12">

                {{-- UNALLOCATED ITEMS --}}
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Unallocated Items (No Supplier)</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="unallocatedTable"
                                class="table table-hover table-bordered table-striped table-sm">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th rowspan="2">Item Code</th>
                                        <th rowspan="2">Description</th>
                                        <th rowspan="2">Cost</th>
                                        <th rowspan="2">Total</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    @foreach ($unallocatedItems as $item)
                                        <tr>
                                            <td>{{ $item['item_code'] }}</td>
                                            <td>{{ $item['description'] }}</td>
                                            <td class="text-right">{{ $item['cost'] }}</td>
                                            <td class="text-right">{{ $item['total'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                @foreach ($purchaseOrdered as $po_suppliers)
                    @php
                        $costPlanCostTotal = 0;
                        $costPlanCostSubTotal = 0;
                        $purchaseOrderTotal = 0;
                        $existItemCode = [];

                    @endphp
                    {{-- SUPPLIER TABLE --}}
                    <div class="card card-primary card-outline po-container">
                        <div class="card-header d-flex justify-content-round align-items-center">
                            <div class="left w-50">
                                <h3 class="card-title">Supplier: {{ $po_suppliers['supplierName'] }}</h3>
                            </div>
                            <div class="right w-50 text-right">
                                <button class="btn btn-primary create-invoice-btn"> <i class="fa fa-plus-square"
                                        aria-hidden="true"></i> Create Invoice </button>

                                <button class="alter-invoice-btn btn btn-primary d-none  save-invoice-btn"> <i
                                        class="fa fa-check-square" aria-hidden="true"></i> Save Invoice </button>
                                <button class="alter-invoice-btn btn btn-danger  d-none cancel-invoice-btn"> <i
                                        class="fa fa-times" aria-hidden="true"></i> Cancel </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="supplierTable1"
                                    class="table table-hover table-bordered table-striped table-sm">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th rowspan="2">Item Code</th>
                                            <th rowspan="2">Description</th>
                                            <th rowspan="2">Cost</th>
                                            <th rowspan="2">Total</th>
                                            <th colspan="2">Purchase Order</th>
                                            <th colspan="2">Invoice</th>
                                        </tr>
                                        <tr>
                                            <th>PO No.</th>
                                            <th>Amount</th>
                                            <th>Invoice No.</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($po_suppliers['items'] as $po_item)
                                            @php
                                                $unitCost = $po_item->cost_plan_items->cost;
                                                $totalCost = $po_item->cost_plan_items->total;
                                                $poTotal = $po_item->total;
                                                $poId = str_pad($po_item->purchase_order_id, 5, '0', STR_PAD_LEFT);

                                                $isDuplicate = in_array($po_item->item_code, $existItemCode);

                                                if(!$isDuplicate){
                                                    $costPlanCostTotal += $unitCost;
                                                    $costPlanCostSubTotal += $totalCost;
                                                }

                                                $purchaseOrderTotal += $poTotal;

                                                $existItemCode[] += $po_item->item_code;
                                                // array_push($existItemCode, $po_item->item_code);

                                            @endphp
                                            <tr class="po-table-row">
                                                <td>{{ $po_item->item_code }} </td>
                                                <td>{{ $po_item->description }}</td>
                                                <td class="text-right">{{ $isDuplicate ? "-" : number_format($unitCost, 2)  }}</td>
                                                <td class="text-right">{{ $isDuplicate ? "-" : number_format($totalCost, 2) }}</td>
                                                <td>PO-{{ $poId }}</td>
                                                <td class="text-right">{{ number_format($po_item->total, 2) }}</td>
                                                <td class="po-invoice-number"> - </td>
                                                <td class="po-invoice-amount"> - </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2"> Supplier Total </th>
                                            <th class="text-right">{{number_format($costPlanCostTotal, 2)}}</th>
                                            <th class="text-right">{{number_format($costPlanCostSubTotal, 2)}}</th>
                                            <th colspan="2" class="text-right">{{number_format($purchaseOrderTotal, 2)}}</th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>


    @section('scripts')
        @include('includes.datatables-scripts')

        <script>
            $(function() {

                // if (!$.fn.DataTable.isDataTable('#unallocatedTable')) {
                //     $('#unallocatedTable').DataTable({
                //         responsive: true,
                //         autoWidth: false,
                //         paging: true
                //     });
                // }

                // if (!$.fn.DataTable.isDataTable('#supplierTable1')) {
                //     $('#supplierTable1').DataTable({
                //         responsive: true,
                //         autoWidth: false,
                //         paging: true
                //     });
                // }


                $(document).on("click", ".create-invoice-btn", function() {
                    const $container = $(this).closest(".po-container");
                    const $createBtn = $(this);
                    const $alterBtn = $container.find(".alter-invoice-btn");
                    const $rows = $container.find(".po-table-row");

                    $rows.each((index, element) =>  {
                        const $row = $(element);

                        const $input = $("<input>", {
                            type: "number",
                            step: "0.01",
                            name: "invoice_amount[]",
                            class: "form-control form-control-sm text-right",
                            value: ""
                        });

                        $row.find(".po-invoice-amount").html($input);
                    });

                    $alterBtn.removeClass("d-none");
                    $createBtn.addClass("d-none");
                });

                $(document).on("click",".save-invoice-btn", function(){
                    const $container = $(this).closest(".po-container");
                    const $createBtn = $container.find(".create-invoice-btn");
                    const $alterBtn = $(this);
                    const $rows = $container.find(".po-table-row");

                    $rows.each((index, element) =>  {
                        const $row = $(element);
                        const invoiceNo = "INV-00001";
                        const $input = "100.00";

                        $row.find(".po-invoice-number").html(invoiceNo);
                        $row.find(".po-invoice-amount").html($input);
                    });

                    $alterBtn.addClass("d-none");
                    $createBtn.removeClass("d-none");
                });

            });
        </script>
    @endsection

</x-app-layout>
