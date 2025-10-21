<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>

    <x-slot name="pageTitle">
        Clients
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Clients List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('clients.create') }}">
                                <button class="btn btn-primary">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp; Create New Client
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
                                    <th>Industry</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Acme Property Holdings Ltd.</td>
                                    <td>22 King Street, London, W1A 1AA</td>
                                    <td>Real Estate</td>
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
