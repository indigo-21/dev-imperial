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
                                <button class="btn btn-primary">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                    &nbsp; Create new Project
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Project Reference</th>
                                    <th>Client</th>
                                    <th>Project Type</th>
                                    <th>Project Director</th>
                                    <th class="text-center" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PRJ-001</td>
                                    <td>Acme Construction</td>
                                    <td>Refurb</td>
                                    <td>Emily Carter</td>
                                    <td class="text-center">
                                        <a type="submit" href="{{url('projects/edit/project-detail/1')}}" class="btn btn-sm btn-outline-primary" title="Edit Project">
                                                <i class="fa fa-pen"></i>
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
