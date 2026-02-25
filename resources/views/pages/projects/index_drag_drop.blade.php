<x-app-layout>
    <x-slot name="importedLinks">
        @include('includes.datatables-links')
        <!-- jQuery UI CSS for sortable placeholder -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
        <style>
            /* .division-column { min-height: 200px; } */
            .project-item { cursor: move; }
            .ui-state-highlight { height: 40px; background: #f0f0f0; border: 1px dashed #ccc; }
        </style>
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
                            <h3 class="card-title">Projects List (Drag & Drop by Division)</h3>
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
                        <!-- Example: assumes $divisions collection each with ->name and ->projects relationship -->
                        <div class="row">
                            @foreach($divisions as $division)
                                <div class="col-md-4">
                                    <div class="card division-column">
                                        <div class="card-header">
                                            <strong>{{ $division["name"] }}</strong>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group connectedSortable-{{ $division["id"] }}" data-division-id="{{ $division['id'] }}">
                                                @foreach($projects as $project)
                                                    <li class="list-group-item project-item" data-id="{{ $project->id }}">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ "PRJ-" . str_pad($project->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                                                <div class="small text-muted">{{ $project->client->business_name ?? '' }}</div>
                                                            </div>
                                                            <div class="text-right">
                                                                <a href='{{ url("projects/edit/project-detail/$project->id") }}' class="btn btn-sm btn-outline-primary" title="Edit Project">
                                                                    <i class="fa fa-pen"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <button id="saveOrderBtn" class="btn btn-success">Save Order</button>
                            <small class="text-muted ml-2">Drag projects between divisions or reorder within a division.</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        @include('includes.datatables-scripts')
        <script>
            $(function(){
                // Enable connected sortable lists
                $(".connectedSortable-1").sortable({
                    connectWith: ".connectedSortable-1",
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true
                }).disableSelection();

                $(".connectedSortable-2").sortable({
                    connectWith: ".connectedSortable-2",
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true
                }).disableSelection();

                // Gather order for all divisions and POST to server
                $("#saveOrderBtn").on("click", function(){
                   
                }); 
            });
        </script>
    @endsection
</x-app-layout>