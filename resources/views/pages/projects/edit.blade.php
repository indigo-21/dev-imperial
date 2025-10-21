<x-app-layout>
    <x-slot name="pageTitle">
        Edit Project
    </x-slot>

    <x-slot name="content">
        @php
            // Dummy data for demo purposes
            $project = (object) [
                'id' => 1,
                'project_description' => 'Office refurbishment and workspace redesign for head office.',
                'project_reference' => 'PRJ-001',
                'client_id' => 2,
                'project_type' => 'Refurb',
                'project_size' => 15000,
                'client_budget' => 2500000.00,
                'lead_source' => 'Architect Referral',
                'lead_owner' => 'James Carter',
                'project_director' => 'Emily Carter',
                'pre_construction' => 'Michael Reynolds',
                'designer' => 'BrightSpace Studio',
                'high_risk_building' => true,
                'referral_fee' => 5.0,
            ];
        @endphp

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Project Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Project Reference -->
                            <div class="col-md-4 mb-3">
                                <strong>Project Reference:</strong>
                                <p class="mb-0">{{ $project->project_reference ?? 'N/A' }}</p>
                            </div>

                            <!-- Client -->
                            <div class="col-md-4 mb-3">
                                <strong>Client:</strong>
                                <p class="mb-0">Acme Construction</p>
                            </div>
                              <div class="col-md-4 mb-3">
                                <strong>High Risk Building:</strong>
                                <p class="mb-0">No</p>
                            </div>
                        </div>
                    </div>
                </div>

                 {{-- 🧭 PROJECT TABS SECTION --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                                aria-controls="details" aria-selected="true">Project Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab"
                                                aria-controls="documents" aria-selected="false">Project Files</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab"
                                                aria-controls="template" aria-selected="false">Project Sections</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="costplan-tab" data-toggle="tab" href="#costplan" role="tab"
                                                aria-controls="costplan" aria-selected="false">Cost Plan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="variation-tab" data-toggle="tab" href="#variation" role="tab"
                                                aria-controls="variation" aria-selected="false">Variation Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab"
                                                aria-controls="summary" aria-selected="false">Summary</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="projectTabsContent">
                                        {{-- Project Details --}}
                                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                         

                                                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="card-body">
                                                        <div class="row">
                                                            {{-- Project Description --}}
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="project_description">Project Description</label>
                                                                    <textarea name="project_description" id="project_description" class="form-control" rows="3">{{ $project->project_description }}</textarea>
                                                                </div>
                                                            </div>

                                                            {{-- Project Reference --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="project_reference">Project Reference</label>
                                                                    <input type="text" name="project_reference" id="project_reference" class="form-control"
                                                                        value="{{ $project->project_reference }}" readonly>
                                                                </div>
                                                            </div>

                                                            {{-- Client --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="client_id">Client</label>
                                                                    <select name="client_id" id="client_id" class="form-control">
                                                                        <option value="">-- Select Client --</option>
                                                                        <option value="1" {{ $project->client_id == 1 ? 'selected' : '' }}>John Doe Ltd</option>
                                                                        <option value="2" {{ $project->client_id == 2 ? 'selected' : '' }}>Acme Construction</option>
                                                                        <option value="3" {{ $project->client_id == 3 ? 'selected' : '' }}>Sunrise Developers</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- Project Type --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="project_type">Project Type</label>
                                                                    <select name="project_type" id="project_type" class="form-control">
                                                                        <option value="">-- Select Type --</option>
                                                                        <option value="Refurb" {{ $project->project_type == 'Refurb' ? 'selected' : '' }}>Refurb</option>
                                                                        <option value="Relocation" {{ $project->project_type == 'Relocation' ? 'selected' : '' }}>Relocation</option>
                                                                        <option value="Refresh/Small Works" {{ $project->project_type == 'Refresh/Small Works' ? 'selected' : '' }}>Refresh/Small Works</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            {{-- Size --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="project_size">Size (sqft)</label>
                                                                    <input type="number" name="project_size" id="project_size" class="form-control"
                                                                        value="{{ $project->project_size }}">
                                                                </div>
                                                            </div>

                                                            {{-- Client Budget --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="client_budget">Client Budget (£)</label>
                                                                    <input type="number" step="0.01" name="client_budget" id="client_budget" class="form-control"
                                                                        value="{{ $project->client_budget }}">
                                                                </div>
                                                            </div>

                                                            {{-- Lead Source --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lead_source">Lead Source</label>
                                                                    <input type="text" name="lead_source" id="lead_source" class="form-control"
                                                                        value="{{ $project->lead_source }}">
                                                                </div>
                                                            </div>

                                                            {{-- Lead Owner --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lead_owner">Lead Owner</label>
                                                                    <input type="text" name="lead_owner" id="lead_owner" class="form-control"
                                                                        value="{{ $project->lead_owner }}">
                                                                </div>
                                                            </div>

                                                            {{-- Project Director --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="project_director">Project Director</label>
                                                                    <input type="text" name="project_director" id="project_director" class="form-control"
                                                                        value="{{ $project->project_director }}">
                                                                </div>
                                                            </div>

                                                            {{-- Pre-Construction --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="pre_construction">Pre-Construction</label>
                                                                    <input type="text" name="pre_construction" id="pre_construction" class="form-control"
                                                                        value="{{ $project->pre_construction }}">
                                                                </div>
                                                            </div>

                                                            {{-- Designer --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="designer">Designer</label>
                                                                    <input type="text" name="designer" id="designer" class="form-control"
                                                                        value="{{ $project->designer }}">
                                                                </div>
                                                            </div>

                                                            {{-- High Risk Building --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group form-check mt-4">
                                                                    <input type="checkbox" name="high_risk_building" id="high_risk_building"
                                                                        class="form-check-input" {{ $project->high_risk_building ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="high_risk_building">High Risk Building</label>
                                                                </div>
                                                            </div>

                                                            {{-- Referral Fee --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="referral_fee">Referral Fee (%)</label>
                                                                    <input type="number" step="0.01" name="referral_fee" id="referral_fee" class="form-control"
                                                                        value="{{ $project->referral_fee }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </form>
                                        </div>

                                       {{-- Documents --}}
                                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                                        <div class="row">
                                            {{-- Upload Form --}}
                                            <div class="col-md-12">
                                            
                                                <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                     <div class="col-md-6">
                                                        {{-- File Description --}}
                                                        <div class="form-group">
                                                            <label for="description">File Description</label>
                                                            <input type="text" name="description" id="description" class="form-control"
                                                                placeholder="Enter a brief description">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6"> 
                                                         {{-- File Upload --}}
                                                        <div class="form-group">
                                                            <label for="document">Select Document</label>
                                                            <input type="file" name="document" id="document" class="form-control-file">
                                                        </div>
                                                         {{-- Buttons --}}
                                                        <div class="form-group mt-3">
                                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                                            <button type="submit" class="btn btn-primary ml-2">Upload</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Document List Table --}}
                                            <div class="col-md-12">
                                                <h5 class="mb-3 text-center"><strong>Uploaded Documents</strong></h5>
                                                <table id="documentsTable" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">ID</th>
                                                            <th width="25%">Description</th>
                                                            <th width="25%">File Name</th>
                                                            <th width="20%">Uploaded By</th>
                                                            <th width="15%">Date</th>
                                                            <th width="10%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Example demo data --}}
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Site Layout Plan</td>
                                                            <td><a href="#">layout_plan.pdf</a></td>
                                                            <td>Sarah Thompson</td>
                                                            <td>2025-10-20</td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                                                <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                        {{-- Project Template --}}
                                    <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                    <form action="{{ isset($project) ? route('costPlans.update', $project->id) : route('costPlans.store') }}" method="POST">
                                                        @csrf
                                                        @if (isset($project))
                                                            @method('PUT')
                                                        @endif

                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                              

                                                                    {{-- Dynamic Section Area --}}
                                                                    <div class="form-group">
                                                                        <div id="sections-wrapper">
                                                                            <!-- Sections will be added dynamically -->
                                                                        </div>

                                                                        <button type="button" class="btn btn-success mt-3" onclick="addSection()">+ Add Section</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>

                                        {{-- Cost Plan --}}
                                        <div class="tab-pane fade" id="costplan" role="tabpanel" aria-labelledby="costplan-tab">
                                            <form action="{{ route('section_items.store') }}" method="POST">
                                            @csrf
                                            @php
                                                $sections = [
                                                    '1.00 Demolition & Site Preparation',
                                                    '2.00 Subfloor',
                                                    '3.00 Ceiling Works',
                                                    '4.00 Partitions & Walls',
                                                    '5.00 Furniture & Fixtures',
                                                    '6.00 Electrical & Lighting',
                                                    '7.00 Mechanical (HVAC)',
                                                    '8.00 Finishes & Painting'
                                                ];

                                                $suppliers = [
                                                    'Select Supplier',
                                                    'ABC Supplies Ltd.',
                                                    'BuildPro Contractors',
                                                    'Elite Interiors Co.',
                                                    'Metro Electricals',
                                                    'Global HVAC Solutions'
                                                ];
                                            @endphp

                                            @foreach($sections as $index => $section)
                                                <div class="card card-primary card-outline mb-4">
                                                    <div class="card-header">
                                                        <h5 class="card-title">{{ $section }}</h5>
                                                    </div>
                                                    <div class="card-body section-card" data-section="{{ $index + 1 }}">
                                                        <div class="section-items">
                                                            <div class="form-group row mb-3 section-item-row">
                                                                <div class="col-md-1">
                                                                    <label>Code</label>
                                                                    <input type="text" name="codes[{{ $index }}][]" class="form-control code-input" readonly value="{{ $index + 1 }}.01">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Item Description</label>
                                                                    <input type="text" name="item_names[{{ $index }}][]" class="form-control" placeholder="Enter item description">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>Quantity</label>
                                                                    <input type="number" name="quantities[{{ $index }}][]" class="form-control" min="1" value="1">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label>Unit</label>
                                                                    <input type="text" name="units[{{ $index }}][]" class="form-control" placeholder="e.g. sqm, lm">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Supplier</label>
                                                                    <select name="suppliers[{{ $index }}][]" class="form-control">
                                                                        @foreach($suppliers as $supplier)
                                                                            <option value="{{ $supplier }}">{{ $supplier }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1 d-flex align-items-end">
                                                                    <button type="button" class="btn btn-danger remove-row">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="button" class="btn btn-primary add-section-item mb-3">
                                                            <i class="fas fa-plus"></i> &nbsp; Add Item
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <button type="submit" class="btn btn-success">Save All Sections</button>
                                        </form>
                                        </div>

                                        {{-- Variation Order --}}
                                        <div class="tab-pane fade" id="variation" role="tabpanel" aria-labelledby="variation-tab">

                                            <div class="card-header d-flex justify-content-between align-items-center">
                                            
                                                <button id="create-vo-btn" type="button" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> &nbsp; Create Variation Order
                                                </button>
                                            </div>

                                            <div class="card-body">

                                                <!-- TABLE: Existing Variation Orders -->
                                                <div id="variation-table">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Variation Order No.</th>
                                                                <th>Date Created</th>
                                                                <th>Last Updated By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>VO-01</td>
                                                                <td>2025-09-18</td>
                                                                <td>Christine Carillo</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- FORM: Create Variation Order -->
                                                <div id="create-vo-form" style="display: none;">
                                                    <form id="variationForm" action="{{ route('section_items.store') }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="variation_order">Variation Order No.</label>
                                                            <input type="text" name="variation_order" id="variation_order" class="form-control" readonly>
                                                        </div>

                                                        @php
                                                                            $items = [
                                                                                '1.00 Demolition & Site Preparation',
                                                                                '2.00 Subfloor',
                                                                                '3.00 Ceiling Works',
                                                                                '4.00 Partitions & Walls',
                                                                                '5.00 Furniture & Fixtures',
                                                                                '6.00 Electrical & Lighting',
                                                                                '7.00 Mechanical (HVAC)',
                                                                                '8.00 Finishes & Painting'
                                                                            ];
                                                                        @endphp
                                                        @foreach ($items as $item)
                                                            <label class="d-flex align-items-center mb-2 selectable-label">
                                                                <div class="select-box mr-2" onclick="toggleBox(this)"></div>
                                                                <input type="hidden" name="scope_items[]" value="{{ $item }}" disabled>
                                                                <span>{{ $item }}</span>
                                                            </label>
                                                        @endforeach

                                                        <div class="text-right">
                                                            <button type="button" id="proceed-btn" class="btn btn-success">Proceed</button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <!-- SECTION ITEMS FORM -->
                                                <div id="section-items-form" style="display: none;">
                                                    <form action="{{ route('section_items.store') }}" method="POST">
                                                        @csrf
                                                        @php
                                                            $sections = [
                                                                '2.00 Subfloor',
                                                                '3.00 Ceiling Works',
                                                                '4.00 Partitions & Walls'
                                                            ];

                                                            $section2Items = [
                                                                'Take up raised floor panels for access to the services in the floor void and re-lay on completion.',
                                                                'Create new cut out for new floor boxes/grommets.',
                                                                'Repair damaged raised floor panels and ensure level finish.',
                                                                'Supply and install new raised access floor panels to match existing.'
                                                            ];
                                                        @endphp

                                                        @foreach($sections as $index => $section)
                                                            <div class="card card-primary card-outline mb-4">
                                                                <div class="card-header">
                                                                    <h5 class="card-title">{{ $section }}</h5>
                                                                </div>
                                                                <div class="card-body section-card" data-section="{{ $index + 2 }}">
                                                                    <div class="section-items">

                                                                        @if($index === 0)
                                                                            @foreach($section2Items as $itemIndex => $item)
                                                                                <div class="form-group row mb-3 section-item-row">
                                                                                    <div class="col-md-1">
                                                                                        <label>Code</label>
                                                                                        <input type="text" name="codes[{{ $index }}][]" class="form-control code-input" readonly value="2.{{ sprintf('%02d', $itemIndex + 1) }}">
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <label>Item Description</label>
                                                                                        <input type="text" name="item_names[{{ $index }}][]" class="form-control" value="{{ $item }}">
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label>Quantity</label>
                                                                                        <input type="number" name="quantities[{{ $index }}][]" class="form-control" min="1" value="1">
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <label>Unit</label>
                                                                                        <input type="text" name="units[{{ $index }}][]" class="form-control" placeholder="e.g. sqm, lm">
                                                                                    </div>
                                                                                      <div class="col-md-3">
                                                                                        <label>Supplier</label>
                                                                                        <select name="suppliers[{{ $index }}][]" class="form-control">
                                                                                            @foreach($suppliers as $supplier)
                                                                                                <option value="{{ $supplier }}">{{ $supplier }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-1 d-flex align-items-end">
                                                                                        <button type="button" class="btn btn-danger remove-row">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div class="form-group row mb-3 section-item-row">
                                                                                <div class="col-md-1">
                                                                                    <label>Code</label>
                                                                                    <input type="text" name="codes[{{ $index }}][]" class="form-control code-input" readonly value="{{ $index + 1 }}.01">
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <label>Item Description</label>
                                                                                    <input type="text" name="item_names[{{ $index }}][]" class="form-control" placeholder="Enter item description">
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label>Quantity</label>
                                                                                    <input type="number" name="quantities[{{ $index }}][]" class="form-control" min="1" value="1">
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label>Unit</label>
                                                                                    <input type="text" name="units[{{ $index }}][]" class="form-control" placeholder="e.g. sqm, lm">
                                                                                </div>
                                                                                  <div class="col-md-3">
                                                                                        <label>Supplier</label>
                                                                                        <select name="suppliers[{{ $index }}][]" class="form-control">
                                                                                            @foreach($suppliers as $supplier)
                                                                                                <option value="{{ $supplier }}">{{ $supplier }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                <div class="col-md-1 d-flex align-items-end">
                                                                                    <button type="button" class="btn btn-danger remove-row">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    </div>

                                                                    <button type="button" class="btn btn-primary add-section-item mb-3">
                                                                        <i class="fas fa-plus"></i> &nbsp; Add Item
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </form>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Summary --}}
                                        <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                                            <p class="text-muted">Show a summary or report of the project here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </x-slot>
    @section('scripts') 
       <script>

        let sectionCount = 0;

          function addSection() {
            sectionCount++;

            let sectionHtml = `
                <div class="card mt-3 p-3 section-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="mb-0 section-label"></label>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSection(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" class="section-code" name="sections[${sectionCount}][code]" value="">
                    <input type="text" name="sections[${sectionCount}][name]" 
                        class="form-control mt-2" placeholder="Enter section name">
                </div>
            `;

            document.getElementById('sections-wrapper').insertAdjacentHTML('beforeend', sectionHtml);

            renumberSections();
        }

         function deleteSection(button) {
            button.closest('.section-row').remove();
            renumberSections();
        }

        function renumberSections() {
            let sections = document.querySelectorAll('.section-row');
            sections.forEach((row, index) => {
                let number = (index + 1) + ".00";
                row.querySelector('.section-label').innerText = "Section " + number;
                row.querySelector('.section-code').value = number;
            });
        }

document.addEventListener("DOMContentLoaded", function () {

    

    /* -------------------------------
       COST PLAN SECTION LOGIC
    --------------------------------*/
    const costPlanCards = document.querySelectorAll("#costplan .section-card");

    costPlanCards.forEach((sectionCard) => {
        const sectionNumber = sectionCard.dataset.section;

        function updateCostPlanCodes() {
            const rows = sectionCard.querySelectorAll(".section-item-row");
            rows.forEach((row, index) => {
                const codeInput = row.querySelector(".code-input");
                codeInput.value = sectionNumber + "." + String(index + 1).padStart(2, '0');
            });
        }

        sectionCard.querySelector(".add-section-item").addEventListener("click", function () {
            const container = sectionCard.querySelector(".section-items");
            const suppliers = @json($suppliers);

            const newRow = document.createElement("div");
            newRow.classList.add("form-group", "row", "mb-3", "section-item-row");
            newRow.innerHTML = `
                <div class="col-md-1">
                    <label>Code</label>
                    <input type="text" class="form-control code-input" readonly>
                </div>
                <div class="col-md-3">
                    <label>Item Description</label>
                    <input type="text" name="item_names[${sectionNumber}][]" class="form-control" placeholder="Enter item description">
                </div>
                <div class="col-md-2">
                    <label>Quantity</label>
                    <input type="number" name="quantities[${sectionNumber}][]" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-2">
                    <label>Unit</label>
                    <input type="text" name="units[${sectionNumber}][]" class="form-control" placeholder="e.g. sqm, lm">
                </div>
                <div class="col-md-3">
                    <label>Supplier</label>
                    <select name="suppliers[${sectionNumber}][]" class="form-control">
                        ${suppliers.map(s => `<option value="${s}">${s}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;
            container.appendChild(newRow);
            updateCostPlanCodes();
        });

        sectionCard.addEventListener("click", (e) => {
            if (e.target.closest(".remove-row")) {
                e.target.closest(".section-item-row").remove();
                updateCostPlanCodes();
            }
        });

        updateCostPlanCodes();
    });


    /* -------------------------------
       VARIATION ORDER SECTION LOGIC
    --------------------------------*/
    const variationCards = document.querySelectorAll("#section-items-form .section-card");

    variationCards.forEach((sectionCard) => {
        const sectionNumber = sectionCard.dataset.section;

        function updateVariationCodes() {
            const rows = sectionCard.querySelectorAll(".section-item-row");
            rows.forEach((row, index) => {
                const codeInput = row.querySelector(".code-input");
                codeInput.value = sectionNumber + "." + String(index + 1).padStart(2, '0');
            });
        }

        sectionCard.querySelector(".add-section-item").addEventListener("click", function () {
            const container = sectionCard.querySelector(".section-items");
            const suppliers = @json($suppliers);

            const newRow = document.createElement("div");
            newRow.classList.add("form-group", "row", "mb-3", "section-item-row");
            newRow.innerHTML = `
                <div class="col-md-1">
                    <label>Code</label>
                    <input type="text" class="form-control code-input" readonly>
                </div>
                <div class="col-md-3">
                    <label>Item Description</label>
                    <input type="text" name="item_names[${sectionNumber}][]" class="form-control" placeholder="Enter item description">
                </div>
                <div class="col-md-2">
                    <label>Quantity</label>
                    <input type="number" name="quantities[${sectionNumber}][]" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-2">
                    <label>Unit</label>
                    <input type="text" name="units[${sectionNumber}][]" class="form-control" placeholder="e.g. sqm, lm">
                </div>
                <div class="col-md-3">
                    <label>Supplier</label>
                    <select name="suppliers[${sectionNumber}][]" class="form-control">
                        ${suppliers.map(s => `<option value="${s}">${s}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;
            container.appendChild(newRow);
            updateVariationCodes();
        });

        sectionCard.addEventListener("click", (e) => {
            if (e.target.closest(".remove-row")) {
                e.target.closest(".section-item-row").remove();
                updateVariationCodes();
            }
        });

        updateVariationCodes();
    });


    /* -------------------------------
       VARIATION ORDER CREATION LOGIC
    --------------------------------*/
    const createVoBtn = document.getElementById('create-vo-btn');
    const variationTable = document.getElementById('variation-table');
    const createVoForm = document.getElementById('create-vo-form');
    const sectionItemsForm = document.getElementById('section-items-form');

    if (createVoBtn) {
        createVoBtn.addEventListener('click', function () {
            variationTable.style.display = 'none';
            createVoForm.style.display = 'block';
            generateNextVO();
        });
    }

    const proceedBtn = document.getElementById('proceed-btn');
    if (proceedBtn) {
        proceedBtn.addEventListener('click', function () {
            createVoForm.style.display = 'none';
            sectionItemsForm.style.display = 'block';
        });
    }

    function generateNextVO() {
        const lastVO = 'VO-01'; // Ideally fetched dynamically later
        const lastNumber = parseInt(lastVO.split('-')[1]);
        const nextNumber = (lastNumber + 1).toString().padStart(2, '0');
        document.getElementById('variation_order').value = 'VO-' + nextNumber;
    }

    /* -------------------------------
       SELECTABLE SCOPE BOXES
    --------------------------------*/
    window.toggleBox = function (box) {
        box.classList.toggle('selected');
        const input = box.nextElementSibling;
        input.disabled = !input.disabled;
    };

});
</script>

    <style>
        .selectable-label {
            cursor: pointer;
        }
        .select-box {
            width: 20px;
            height: 20px;
            border: 2px solid #ced4da;
            border-radius: 4px;
            margin-right: 8px;
            flex-shrink: 0;
            transition: 0.2s;
        }
        .select-box.selected {
            background-color: #28a745;
            border-color: #28a745;
        }
        .select-box:hover {
            border-color: #28a745;
        }
    </style>

    @endsection
</x-app-layout>
