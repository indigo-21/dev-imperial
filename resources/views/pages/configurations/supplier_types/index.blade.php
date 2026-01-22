<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>

    <x-slot name="pageTitle">
        Supplier Types
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Supplier Types List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('supplier-types.create') }}">
                                <button class="btn btn-primary">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp; Create New Supplier Type
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Supplier Type Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplierTypes as $supplierType)
                                    <tr>
                                        <td>{{ $supplierType->id }}</td>
                                        <td>{{ $supplierType->name }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('supplier-types.edit', $supplierType->id) }}" method="GET" class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pen"></i>
                                                    Edit
                                                </button>
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
