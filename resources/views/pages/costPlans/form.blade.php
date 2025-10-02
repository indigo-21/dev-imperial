<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($project) ? 'Edit' : 'Create' }} Cost Plan
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Cost Details</h3>
                    </div>
                    <form action="{{ isset($project) ? route('costPlans.update', $project->id) : route('costPlans.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Project</label>
                                            <select class="form-control select2bs4" name="project_id" style="width: 100%;">
                                                <option value="">-- Select Project --</option>
                                                <option value="1">Project Alpha</option>
                                                <option value="2">Project Beta</option>
                                                <option value="3">Project Gamma</option>
                                                <option value="4">Project Delta</option>

                                            </select>
                                        </div>

                                         <div class="form-group">
                                            <label>Project Scope Template</label>
                                            <select class="form-control select2bs4" id="project-template" name="project-template" style="width: 100%;">
                                                <option value="">-- Select Project Scope Template--</option>
                                                <option value="1">Template 1</option>
                                                <option value="2">Template 2</option>
                                            </select>
                                        </div>

                                        
                                        <!-- Hidden card that will display template details -->
                                        <div id="template-details" class="card mt-3" style="display: none;">
                                            <div class="card-header">
                                                <h5 class="card-title">Project Scope</h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    <li class="list-group-item">1.00 Demolition & Site Preparation</li>
                                                    <li class="list-group-item">2.00 Subfloor</li>
                                                    <li class="list-group-item">3.00 Ceiling Works</li>
                                                    <li class="list-group-item">4.00 Partitions & Walls</li>
                                                    <li class="list-group-item">5.00 Furniture & Fixtures</li>
                                                    <li class="list-group-item">6.00 Electrical & Lighting</li>
                                                    <li class="list-group-item">7.00 Mechanical (HVAC)</li>
                                                    <li class="list-group-item">8.00 Finishes & Painting</li>
                                                </ul>
                                                
                                                <a href="{{ route('section_items.create') }}" class="float-right btn btn-success mt-5" id="proceed-link">
                                                    Proceed
                                                </a>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
    @section('scripts')
       <script>
           $(document).ready(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                $('#project-template').on('change', function () {
                    let selected = $(this).val();

                    if (selected === "1") {
                        $('#template-details').slideDown();
                    } else {
                        $('#template-details').slideUp();
                    }
                });
            });
       </script>

    @endsection
</x-app-layout>
