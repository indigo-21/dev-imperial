<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Section Items List
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            <h3 class="card-title">Section Items</h3>
                        </div>
                    </div>
                    <div class="card-body">
                      <table id="defaultTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2.01</td>
                                    <td>Take up raised floor panels for access to the services in the floor void and re-lay on completion.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.02</td>
                                    <td>Create new cut out for new floor boxes/grommets.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.03</td>
                                    <td>Repair damaged raised floor panels and ensure level finish.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2.04</td>
                                    <td>Supply and install new raised access floor panels to match existing.</td>
                                    <td></td>
                                    <td></td>
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
