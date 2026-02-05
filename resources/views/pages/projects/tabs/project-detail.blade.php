@extends("pages.projects.form")
@section('project-detail-tab')
    <form action="{{ isset($project) ? route('projects.update', $project->id) : route("projects.store") }}" method="POST">
        @csrf
        @isset($project)
            @method("PUT")
        @endisset

        <div class="card-body">
            <div class="row">
                {{-- Project Description --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="project_description">Project Description</label>
                        <textarea name="project_description" id="project_description" class="form-control" rows="3" >{{ isset($project) ? $project->description : old("project_description") }}</textarea>
                        <span class="text-danger error">{{$errors->first('project_description')}}</span>
                    </div>
                </div>
                
                {{-- Client --}}
                <div class="col-md-6">
                    <div class="form-group">
                        @php
                            $old_client_id = isset($project) ? $project->client_id : old("client_id");
                        @endphp
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control" >
                            <option value="">-- Select Client --</option>
                            @foreach ($clients as $client )
                            <option value="{{$client->id}}" {{ $old_client_id == $client->id ? 'selected' : '' }}>
                                {{$client->business_name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error">{{$errors->first('client_id')}}</span>
                    </div>
                </div>

                {{-- Project Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        <select name="project_type" id="project_type" class="form-control" >
                            @php
                                $old_project_type = isset($project) ? $project->project_type_id : old("project_type");
                            @endphp
                            <option value="">-- Select Type --</option>
                            @foreach ($project_types as $project_type )
                                <option value="{{$project_type->id}}" 
                                    {{ $old_project_type == $project_type->id ? 'selected' : '' }}>
                                    {{$project_type->name}}</option>                                
                            @endforeach
                        </select>
                        <span class="text-danger error">{{$errors->first('project_type')}}</span>
                    </div>
                </div>

                {{-- Size --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_size">Size (sqft)</label>
                        <input type="number" name="project_size" id="project_size" class="form-control"
                            value="{{ isset($project) ? $project->size : old("project_size") }}">
                    </div>
                </div>

                {{-- Client Budget --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client_budget">Client Budget (£)</label>
                        <input type="number" step="0.01" name="client_budget" id="client_budget" class="form-control"
                            value="{{ isset($project) ? $project->client_budget : old("client_budget") }}">
                    </div>
                </div>

                {{-- Lead Source --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lead_source">Lead Source</label>
                        <input type="text" name="lead_source" id="lead_source" class="form-control"
                            value="{{ isset($project) ? $project->lead_source : old("lead_source") }}">
                    </div>
                </div>

                {{-- Lead Owner --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lead_owner">Lead Owner</label>
                        <input type="text" name="lead_owner" id="lead_owner" class="form-control"
                            value="{{ isset($project) ? $project->lead_owner : old("lead_owner") }}">
                    </div>
                </div>

                {{-- Project Director --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_director">Project Director</label>
                        <input type="text" name="project_director" id="project_director" class="form-control"
                            value="{{ isset($project) ? $project->project_director : old("project_director") }}">
                    </div>
                </div>

                {{-- Pre-Construction --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_status">Project Status</label>
                        <select name="project_status" id="project_status" class="form-control" >
                            @php
                                $selectedStatus = old('project_status', $project->project_status ?? '');
                            @endphp

                            <option value="">-- Select Project Status --
                            </option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error">{{$errors->first('project_status')}}</span>
                    </div>
                </div>


                {{-- Designer --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="designer">Designer</label>
                        <input type="text" name="designer" id="designer" class="form-control"
                            value="{{ isset($project) ? $project->designer : old("designer") }}">
                    </div>
                </div>

                {{-- High Risk Building --}}
                <div class="col-md-6">
                    <div class="form-group">
                        @php
                            $old_is_high_risk_building = isset($project) ? $project->high_risk_building : old("high_risk_building");
                        @endphp
                        <label for="high_risk_building">High Risk Building</label>
                        <select name="high_risk_building" id="high_risk_building" class="form-control">
                            <option value="">-- Select Type --</option>     
                            <option value="0" {{ $old_is_high_risk_building == "0"? 'selected' : '' }} >-- No --</option>                        
                            <option value="1" {{ $old_is_high_risk_building == "1"? 'selected' : '' }} >-- Yes --</option>  
                            <option value="2" {{ $old_is_high_risk_building == "2"? 'selected' : '' }} >-- Unsure --</option>  
                        </select>
                        <span class="text-danger error">{{$errors->first('high_risk_building')}}</span>
                    </div>
                </div>

                {{-- Referral Fee --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="referral_fee">Referral Fee (%)</label>
                        <input type="number" step="0.01" name="referral_fee" id="referral_fee" class="form-control"
                            value="{{ isset($project) ? $project->referral_fee : old("referral_fee") }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer mt-4 d-flex justify-content-end">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary px-5 mr-2">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">
                {{ isset($project) ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
@endsection
