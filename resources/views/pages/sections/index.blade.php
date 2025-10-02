<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
    </x-slot>
    <x-slot name="pageTitle">
        Sections List
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="left w-50">
                            
                            <h3 class="card-title">Sections List</h3>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <table id="defaultTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 15%">Section ID</th>
                                <th>Section Name</th>
                                <th style="width: 30%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.00</td>
                                <td>Demolition & Site Preparation</td>
                                <td>
                                    <a href="{{ route('section_items.index') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>2.00</td>
                                <td>Subfloor</td>
                                <td>
                                     <a href="{{ route('section_items.index') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                   
                                </td>
                            </tr>
                            <tr>
                                <td>3.00</td>
                                <td>Ceiling Works</td>
                                <td>
                                    <a href="{{ route('sections.index', 3) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>4.00</td>
                                <td>Partitions & Walls</td>
                                <td>
                                    <a href="{{ route('sections.index', 4) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>5.00</td>
                                <td>Furniture & Fixtures</td>
                                <td>
                                    <a href="{{ route('sections.index', 5) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>6.00</td>
                                <td>Electrical & Lighting</td>
                                <td>
                                    <a href="{{ route('sections.index', 6) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>7.00</td>
                                <td>Mechanical (HVAC)</td>
                                <td>
                                    <a href="{{ route('sections.index', 7) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>8.00</td>
                                <td>Finishes & Painting</td>
                                <td>
                                    <a href="{{ route('sections.index', 8) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>&nbsp; View Items
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
