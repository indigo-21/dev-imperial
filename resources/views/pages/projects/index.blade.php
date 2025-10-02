<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Projects
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            
                            <h3 class="card-title">Projects List</h3>
                        </div>
                        <div class="right w-50 text-right">
                            <a href="{{ route('projects.create') }}">
                                <button class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i>
                                &nbsp; Create new Project</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Date</th>
                                    <th>Project Reference</th>
                                    <th>Client Name</th>
                                    <th>Client Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>Scope of Works and Budget Costs</td>
                                        <td>7/14/2025</td>
                                        <td>LP 25.1273 RevM</td>
                                        <td>Sordo Madaleno</td>
                                        <td>Ground Floor, The Canal Building, 10 All Saints Street, London, N1 9RL</td>
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
