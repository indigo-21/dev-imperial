<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($project) ? 'Edit' : 'Create' }} Project
    </x-slot>

    <x-slot name="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Project Information</h3>
                    </div>

                    <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif

                        <div class="card-body">
                            <div class="row">

                                {{-- Project Description --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="project_description">Project Description</label>
                                        <textarea name="project_description" id="project_description" class="form-control" rows="3"
                                            placeholder="Enter project description">{{ old('project_description', $project->project_description ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- Project Reference (Auto-generated dummy) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_reference">Project Reference</label>
                                        <input type="text" name="project_reference" id="project_reference"
                                            class="form-control"
                                            value="{{ old('project_reference', $project->project_reference ?? 'PRJ-001') }}"
                                            readonly>
                                    </div>
                                </div>

                                {{-- Client (Static Dropdown) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_id">Client</label>
                                        <select name="client_id" id="client_id" class="form-control">
                                            <option value="">-- Select Client --</option>
                                            <option value="1" {{ old('client_id') == 1 ? 'selected' : '' }}>John Doe Ltd</option>
                                            <option value="2" {{ old('client_id') == 2 ? 'selected' : '' }}>Acme Construction</option>
                                            <option value="3" {{ old('client_id') == 3 ? 'selected' : '' }}>Sunrise Developers</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Project Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_type">Project Type</label>
                                        <select name="project_type" id="project_type" class="form-control">
                                            <option value="">-- Select Type --</option>
                                            <option value="CAT A" {{ old('project_type') == 'CAT A' ? 'selected' : '' }}>CAT A</option>
                                            <option value="CAT A+" {{ old('project_type') == 'CAT A+' ? 'selected' : '' }}>CAT A+</option>
                                            <option value="CAT B" {{ old('project_type') == 'CAT B' ? 'selected' : '' }}>CAT B</option>
                                            <option value="Small Works" {{ old('project_type') == 'Small Works' ? 'selected' : '' }}>Small Works</option>
                                            <option value="Refurbishment" {{ old('project_type') == 'Refurbishment' ? 'selected' : '' }}>Refurbishment</option>
                                            <option value="Reconfiguration" {{ old('project_type') == 'Reconfiguration' ? 'selected' : '' }}>Reconfiguration</option>
                                            <option value="Day 2 Works" {{ old('project_type') == 'Day 2 Works' ? 'selected' : '' }}>Day 2 Works</option>
                                            <option value="Dilapidation" {{ old('project_type') == 'Dilapidation' ? 'selected' : '' }}>Dilapidation</option>
                                            <option value="Design Only" {{ old('project_type') == 'Design Only' ? 'selected' : '' }}>Design Only</option>
                                            <option value="Furniture Only" {{ old('project_type') == 'Furniture Only' ? 'selected' : '' }}>Furniture Only</option>
                                        </select>

                                    </div>
                                </div>

                                {{-- Size (sqft) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_size">Size (sqft)</label>
                                        <input type="number" name="project_size" id="project_size" class="form-control"
                                            value="{{ old('project_size', $project->project_size ?? '') }}"
                                            placeholder="Enter size in sqft">
                                    </div>
                                </div>

                                {{-- Client Budget (£) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_budget">Client Budget (£)</label>
                                        <input type="number" name="client_budget" id="client_budget" class="form-control"
                                            step="0.01"
                                            value="{{ old('client_budget', $project->client_budget ?? '') }}"
                                            placeholder="Enter client budget">
                                    </div>
                                </div>

                                {{-- Lead Source --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_source">Lead Source</label>
                                        <input type="text" name="lead_source" id="lead_source" class="form-control"
                                            value="{{ old('lead_source', $project->lead_source ?? '') }}"
                                            placeholder="Enter lead source">
                                    </div>
                                </div>

                                {{-- Lead Owner --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lead_owner">Lead Owner</label>
                                        <input type="text" name="lead_owner" id="lead_owner" class="form-control"
                                            value="{{ old('lead_owner', $project->lead_owner ?? '') }}"
                                            placeholder="Enter lead owner">
                                    </div>
                                </div>

                                {{-- Project Director --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project_director">Project Director</label>
                                        <input type="text" name="project_director" id="project_director"
                                            class="form-control"
                                            value="{{ old('project_director', $project->project_director ?? '') }}"
                                            placeholder="Enter project director">
                                    </div>
                                </div>

                                {{-- Pre-Construction --}}
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_status">Project Status</label>
                                    <select name="project_status" id="project_status" class="form-control">
                                        @php
                                            $statuses = [
                                                'New Lead',
                                                'Qualification',
                                                'Meeting Stage',
                                                'Design Stage',
                                                'Costing Stage',
                                                'Pitch/Presentation Stage',
                                                'Awaiting Decision',
                                                'Won',
                                                'On Hold',
                                                'Lost',
                                                'Pre-Construction Stage',
                                                'Construction Stage',
                                                'After Care',
                                            ];
                                            $selectedStatus = old('project_status', $project->project_status ?? '');
                                        @endphp

                                        <option value="">-- Select Project Status --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                                {{-- Designer --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="designer">Designer</label>
                                        <input type="text" name="designer" id="designer" class="form-control"
                                            value="{{ old('designer', $project->designer ?? '') }}"
                                            placeholder="Enter designer name">
                                    </div>
                                </div>

                                {{-- High Risk Building (Checkbox) --}}
                                <div class="col-md-6">
                                    <div class="form-group form-check mt-4">
                                        <input type="checkbox" name="high_risk_building" id="high_risk_building"
                                            class="form-check-input"
                                            {{ old('high_risk_building', $project->high_risk_building ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="high_risk_building">High Risk Building</label>
                                    </div>
                                </div>

                                {{-- Referral Fee (%) --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="referral_fee">Referral Fee (%)</label>
                                        <input type="number" step="0.01" name="referral_fee" id="referral_fee"
                                            class="form-control"
                                            value="{{ old('referral_fee', $project->referral_fee ?? '') }}"
                                            placeholder="Enter referral fee percentage">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($project) ? 'Update Project' : 'Create Project' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
