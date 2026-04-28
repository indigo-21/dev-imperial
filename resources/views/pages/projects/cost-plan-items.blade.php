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
                            <table id="unallocatedTable" class="table table-hover table-bordered table-striped table-sm">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th rowspan="2">Item Code</th>
                                        <th rowspan="2">Description</th>
                                        <th rowspan="2">Cost</th>
                                        <th rowspan="2">Total</th>
                                    </tr>
                                   
                                </thead>

                                <tbody>
                                    @foreach ($unallocatedItems as $item )
                                         <tr>
                                            <td>{{$item->item_code}}</td>
                                            <td>{{$item->description}}</td>
                                            <td class="text-right">{{$item->cost}}</td>
                                            <td class="text-right">{{$item->total}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                

                @foreach ($purchaseOrdered as $po_suppliers )
                    {{-- SUPPLIER TABLE --}}
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Supplier: {{$po_suppliers["supplierName"]}}</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="supplierTable1" class="table table-hover table-bordered table-striped table-sm">
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

                                        @foreach ($po_suppliers["items"] as $po_item )
                                            <tr>
                                                <td>{{$po_item->item_code}}</td>
                                                <td>{{$po_item->description}}</td>
                                                <td class="text-right">0.00</td>
                                                <td class="text-right">0.00</td>
                                                <td>{{$po_item->purchaseOrderId}}</td>
                                                <td class="text-right">{{$po_item->total}}</td>

                                                <td>
                                                    <input type="text"
                                                        name="invoice_no[]"
                                                        value=""
                                                        class="form-control form-control-sm">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        step="0.01"
                                                        name="invoice_amount[]"
                                                        value=""
                                                        class="form-control form-control-sm text-right">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Supplier Total</th>
                                            <th class="text-right">0.00</th>
                                            <th colspan="4"></th>
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
            $(function () {

                if (!$.fn.DataTable.isDataTable('#unallocatedTable')) {
                    $('#unallocatedTable').DataTable({
                        responsive: true,
                        autoWidth: false,
                        paging: true
                    });
                }

                if (!$.fn.DataTable.isDataTable('#supplierTable1')) {
                    $('#supplierTable1').DataTable({
                        responsive: true,
                        autoWidth: false,
                        paging: true
                    });
                }

            });
        </script>

    @endsection

</x-app-layout>