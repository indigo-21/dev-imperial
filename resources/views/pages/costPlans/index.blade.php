<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Cost Plans
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            
                            <h3 class="card-title">Cost Plans List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('costPlans.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                &nbsp; Create new Cost Plan</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Project Reference</th>
                                    <th>Sections</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>Sordo Madaleno</td>
                                        <td>LP 25.1273 RevM</td>
                                        <td>8</td>
                                        <td> <a href="{{ route('sections.index') }}" 
                                            class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View Sections
                                            </a>
                                        </td>
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
