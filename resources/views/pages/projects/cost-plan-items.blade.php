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

                                    <tr>
                                        <td>1.01</td>
                                        <td>Concrete Slab</td>
                                        <td class="text-right">500.00</td>
                                        <td class="text-right">5000.00</td>

                                      
                                    </tr>

                                    <tr>
                                        <td>1.02</td>
                                        <td>Steel Beams</td>
                                        <td class="text-right">1000.00</td>
                                        <td class="text-right">5000.00</td>
                                    
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- SUPPLIER TABLE --}}
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Supplier: Supplier 1</h3>
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

                                    <tr>
                                        <td>1.03</td>
                                        <td>Wood Panels</td>
                                        <td class="text-right">600.00</td>
                                        <td class="text-right">12000.00</td>
                                        <td>PO-00003</td>
                                        <td class="text-right">12000.00</td>

                                        <td>
                                            <input type="text"
                                                   name="invoice_no[]"
                                                   value="INV-00003"
                                                   class="form-control form-control-sm">
                                        </td>

                                        <td>
                                            <input type="number"
                                                   step="0.01"
                                                   name="invoice_amount[]"
                                                   value="12000"
                                                   class="form-control form-control-sm text-right">
                                        </td>
                                    </tr>

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Supplier Total</th>
                                        <th class="text-right">12000.00</th>
                                        <th colspan="4"></th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>


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