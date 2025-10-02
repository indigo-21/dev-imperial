<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($project) ? 'Edit' : 'Create' }} Project
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Project Details</h3>
                    </div>
                    <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="project_name">Project Name</label>
                                            <input type="text" name="project_name" class="form-control" id="project_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="project_date">Project Date</label>
                                            <input type="date" name="project_date" class="form-control" id="project_date">
                                        </div>
                                        <div class="form-group">
                                            <label for="project_reference">Project Reference</label>
                                            <input type="text" name="project_reference" class="form-control" id="project_reference" placeholder="Project Reference">
                                        </div>
                                        <div class="form-group">
                                            <label for="project_description">Project Description</label>
                                            <textarea name="project_description" class="form-control" id="project_description" placeholder="Project Description"></textarea>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Client Details</h3>
                    </div>
                    <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                       
                                        <div class="form-group">
                                            <label for="client_name">Client Name</label>
                                            <input type="text" name="client_name" class="form-control" id="client_name" placeholder="Client Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="client_address">Client Address</label>
                                            <input type="text" name="client_address" class="form-control" id="client_address" placeholder="Client Address">
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
       

    @endsection
</x-app-layout>
