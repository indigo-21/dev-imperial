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
                                    <th>ID</th>
                                    <th>Business Name</th>
                                    <th>Business Address</th>
                                    <th>UTR</th>
                                    <th>Company Reg. No.</th>
                                    <th>VAT Number</th>
                                    <th>Supplier Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($suppliers as $supplier)
                                         @php
                                            $typeIds = explode(',', $supplier->supplier_types); // ["1","3","5"]
                                            $typeNames = array_map(fn($id) => $supplierTypes[$id] ?? '-', $typeIds);
                                        @endphp
                                        <tr>
                                            <td>{{ $supplier->id }}</td>
                                            <td>{{ $supplier->business_name }}</td>
                                            <td>{{ $supplier->business_address }}</td>
                                            <td>{{ $supplier->unique_tax_reference }}</td>
                                            <td>{{ $supplier->company_registration_number }}</td>
                                            <td>{{ $supplier->vat_number }}</td>
                                            <td>{{ implode(', ', $typeNames) }}</td>
                                            <td>
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pen"></i>Edit</a>
                                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this supplier?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                 @endforeach
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
