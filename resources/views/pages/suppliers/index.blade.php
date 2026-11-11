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
                                    <th>No.</th>
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
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $supplier->business_name }}</td>
                                            <td>{{ $supplier->business_address }}</td>
                                            <td>{{ $supplier->unique_tax_reference }}</td>
                                            <td>{{ $supplier->company_registration_number }}</td>
                                            <td>{{ $supplier->vat_number }}</td>
                                            <td>{{ implode(', ', $typeNames) }}</td>
                                            <td>
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pen"></i>Edit</a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#deleteSupplierModal{{ $supplier->id }}">
                                                        Delete
                                                    </button>
                                                    <div class="modal fade" id="deleteSupplierModal{{ $supplier->id }}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                    
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Supplier</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                    
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete
                                                                    <strong>{{ $supplier->name }}</strong>?
                                                                    <p class="text-muted mb-0 mt-2">
                                                                        This supplier will be removed from the active supplier list.
                                                                    </p>
                                                                </div>
                                                    
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                        Cancel
                                                                    </button>
                                                    
                                                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                    
                                                                        <button type="submit" class="btn btn-danger">
                                                                            Yes, Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                    
                                                            </div>
                                                        </div>
                                                    </div>
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
        @if (session('success'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('success')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            </script>
        @endif
    @endsection
</x-app-layout>
