<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>

    <x-slot name="pageTitle">
        Sub Contractor / Suppliers
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Sub Contractor / Suppliers List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('suppliers.create') }}">
                                <button class="btn btn-primary">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp; Create new Supplier
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Business Name</th>
                                    <th>Business Address</th>
                                    <th>UTR</th>
                                    <th>Company Reg. No.</th>
                                    <th>VAT Number</th>
                                    <th>Supplier Type</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ABC Electrical Ltd.</td>
                                    <td>12 High Street, London, N1 3AB</td>
                                    <td>1234567890</td>
                                    <td>09876543</td>
                                    <td>GB123456789</td>
                                    <td>Electrical, Data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        @include('includes.datatables-scripts')
        <script src="{{ asset('assets/js/datatables.js') }}"></script>
    @endsection
</x-app-layout>
