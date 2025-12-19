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
                'project_type' => 'CAT A',
                'project_size' => 15000,
                'client_budget' => 2500000.00,
                'lead_source' => 'Architect Referral',
                'lead_owner' => 'James Carter',
                'project_director' => 'Emily Carter',
                'status' => 'Pre-construction',
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
                             <div class="col-md-4 mb-2 p-2 bg-danger text-white rounded">
                                <strong>High Risk Building: No</strong>
                            </div>
                        </div>
                        <div class="row">
                           
                            <div class="col-md-4 mb-3">
                                <strong>Project Reference:</strong>
                                <p class="mb-0">{{ $project->project_reference ?? 'N/A' }}</p>
                            </div>

                            <!-- Client -->
                            <div class="col-md-4 mb-3">
                                <strong>Client:</strong>
                                <p class="mb-0">Acme Construction</p>
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
                                            <a class="nav-link" id="costplan-tab" data-toggle="tab" href="#costplan" role="tab"
                                                aria-controls="costplan" aria-selected="false">Cost Plan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="variation-tab" data-toggle="tab" href="#variation" role="tab"
                                                aria-controls="variation" aria-selected="false">Variation Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab"
                                                aria-controls="summary" aria-selected="false">Adjudication</a>
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
                                                                        <option value="CAT A" {{ $project->project_type == 'CAT A' ? 'selected' : '' }}>CAT A</option>
                                                                        <option value="CAT A+" {{ $project->project_type == 'CAT A+' ? 'selected' : '' }}>CAT A+</option>
                                                                        <option value="CAT B" {{ $project->project_type == 'CAT B' ? 'selected' : '' }}>CAT B</option>
                                                                        <option value="Small Works" {{ $project->project_type == 'Small Works' ? 'selected' : '' }}>Small Works</option>
                                                                        <option value="Refurbishment" {{ $project->project_type == 'Refurbishment' ? 'selected' : '' }}>Refurbishment</option>
                                                                        <option value="Reconfiguration" {{ $project->project_type == 'Reconfiguration' ? 'selected' : '' }}>Reconfiguration</option>
                                                                        <option value="Day 2 Works" {{ $project->project_type == 'Day 2 Works' ? 'selected' : '' }}>Day 2 Works</option>
                                                                        <option value="Dilapidation" {{ $project->project_type == 'Dilapidation' ? 'selected' : '' }}>Dilapidation</option>
                                                                        <option value="Design Only" {{ $project->project_type == 'Design Only' ? 'selected' : '' }}>Design Only</option>
                                                                        <option value="Furniture Only" {{ $project->project_type == 'Furniture Only' ? 'selected' : '' }}>Furniture Only</option>

                                                                                                                                                
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


                                       {{-- Cost Plan --}}
                                    <div class="tab-pane fade" id="costplan" role="tabpanel" aria-labelledby="costplan-tab">
                                        <form action="{{ route('section_items.store') }}" method="POST">
                                            @csrf

                                            @php
                                        

                                                $suppliers = [
                                                'Select Supplier',
                                                'ABC Supplies Ltd.',
                                                'BuildPro Contractors',
                                                'Elite Interiors Co.',
                                                'Metro Electricals',
                                                'Global HVAC Solutions'
                                                ];
                                            @endphp

                                            @foreach($templateSections as $sectionIndex => $section)
                                                <div class="card card-primary card-outline mb-4">
                                                    <div class="card-header d-flex justify-content-between align-items-center"
                                                        data-toggle="collapse"
                                                        data-target="#section-{{ $section->id }}"
                                                        aria-expanded="true"
                                                        aria-controls="section-{{ $section->id }}"
                                                        style="cursor:pointer;">

                                                        <h5 class="card-title mb-0">
                                                            {{ $section->section_code }} - {{ $section->section_name }}
                                                        </h5>

                                                        <div class="d-flex align-items-center ml-auto" onclick="event.stopPropagation();">
                                                            <label class="mb-0 me-2"><strong>Mark Up % &nbsp; </strong></label>
                                                            <input
                                                                type="number"
                                                                step="0.1"
                                                                min="0"
                                                                class="form-control section-markup-input"
                                                                style="width:90px;"
                                                                data-section-id="{{ $section->id }}"
                                                                value="20">
                                                        </div>
                                                    </div>

                                                    <div id="section-{{ $section->id }}" class="collapse show">


                                                    <div class="card-body section-card" data-section="{{ $section->id }}">
                                                        <div class="section-items">

                                                            {{-- Preloaded template items --}}
                                                            @foreach($section->items as $item)
                                                                <div class="form-group row mb-3 section-item-row">
                                                                    
                                                                    <div class="col-md-6 d-flex">
                                                                        <div class="short-input">
                                                                            <label>Code</label>
                                                                            <input 
                                                                                type="text" 
                                                                                name="codes[{{ $section->id }}][]" 
                                                                                class="form-control code-input" 
                                                                                readonly 
                                                                                value="{{ $item->item_code }}">
                                                                        </div>

                                                                        <div class="col">
                                                                            <label>Item Description</label>
                                                                            <textarea 
                                                                            name="item_names[{{ $section->id }}][]" 
                                                                            class="form-control " 
                                                                            rows="4">{{ $item->description }}</textarea>
                                                                    </div>

                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="row g-2">  
                                                                            
                                                                            <!-- Qty (small auto width) -->
                                                                            <div class="col-md-2">
                                                                                <label>Qty</label>
                                                                                <input 
                                                                                    type="number"
                                                                                    name="quantities[{{ $section->id }}][]"
                                                                                    class="form-control calc-field quantity-input"
                                                                                    min="1"
                                                                                    value="{{ $item->quantity }}">
                                                                            </div>

                                                                            <!-- Unit (small auto width) -->
                                                                            <div class="col-md-2">
                                                                                <label>Unit</label>
                                                                                <input 
                                                                                    type="text"
                                                                                    name="units[{{ $section->id }}][]"
                                                                                    class="form-control"
                                                                                    value="{{ $item->unit }}">
                                                                            </div>

                                                                            <!-- Rate (small auto width) -->
                                                                            <div class="col-md-3">
                                                                                <label>Rate</label>
                                                                                <input 
                                                                                    type="number"
                                                                                    step="0.01"
                                                                                    name="rates[{{ $section->id }}][]"
                                                                                    class="form-control calc-field rate-input"
                                                                                    value="{{ $item->rate }}">
                                                                            </div>

                                                                            <!-- Cost (auto-expand) -->
                                                                            <div class="col-md-2">
                                                                                <label>Cost</label>
                                                                                <input 
                                                                                    type="text"
                                                                                    name="costs[{{ $section->id }}][]"
                                                                                    class="form-control cost-output"
                                                                                    readonly>
                                                                            </div>

                                                                            <!-- Total (auto-expand) -->
                                                                            <div class="col-md-2">
                                                                                <label>Total</label>
                                                                                <input 
                                                                                    type="text"
                                                                                    name="totals[{{ $section->id }}][]"
                                                                                    class="form-control total-output"
                                                                                    readonly>
                                                                            </div>

                                                                            <!-- Markup (small auto width) -->
                                                                            <div class="col-md-3 mt-3">
                                                                                <label>Mark Up %</label>
                                                                                <input 
                                                                                    type="number"
                                                                                    step="0.1"
                                                                                    min="0"
                                                                                    name="markups[{{ $section->id }}][]"
                                                                                    class="form-control calc-field markup-input"
                                                                                    value="20">
                                                                            </div>

                                                                            <!-- Supplier (full width on wrap) -->
                                                                            <div class="col mt-3">
                                                                                <label>Supplier</label>
                                                                                <select name="suppliers[{{ $section->id }}][]" class="form-control">
                                                                                    @foreach($suppliers as $supplier)
                                                                                        <option value="{{ $supplier }}">{{ $supplier }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <!-- Remove row button -->
                                                                            <div class="col-auto d-flex align-items-end">
                                                                                <button type="button" class="btn btn-danger remove-row">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                        </div>

                                                        {{-- Subtotal row --}}
                                                       <div class="form-group row mb-3 section-subtotal-row d-flex justify-content-end">
                                                            <div class="col-auto text-end">
                                                                <label><strong>Subtotal</strong></label>
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="text" class="form-control subtotal-cost" readonly placeholder="Cost">
                                                            </div>
                                                            <div class="col-auto">
                                                                <input type="text" class="form-control subtotal-total" readonly placeholder="Total">
                                                            </div>
                                                        </div>
                                                        {{-- Add new item --}}
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-primary add-section-item mb-3"
                                                            data-section-id="{{ $section->id }}"
                                                            data-section-code="{{ $section->section_code }}"
                                                        >
                                                            <i class="fas fa-plus"></i>&nbsp; Add Item
                                                        </button>
                                                    </div>
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
                                            <div class="card mt-3">
                                                <div class="card-header bg-primary text-white">
                                                    <strong>SUMMARY SHEET</strong>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered mb-0">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Section</th>
                                                                    <th class="text-right">Cost £</th>
                                                                    <th class="text-right">Mark Up £</th>
                                                                    <th class="text-right">Profit £</th>
                                                                    <th class="text-right">Gross Profit %</th>
                                                                    <th class="text-right">Total ex. VAT £</th>
                                                                    <th class="text-right">PO Amount £</th>
                                                                    <th class="text-right">Inv Amount £</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1.00</td>
                                                                    <td>DECONSTRUCT / STRIP OUT</td>
                                                                    <td class="text-right">6,000.00</td>
                                                                    <td class="text-right">900.00</td>
                                                                    <td class="text-right">900.00</td>
                                                                    <td class="text-right">15%</td>
                                                                    <td class="text-right">6,900.00</td>
                                                                    <td class="text-right">5,800.00</td>
                                                                    <td class="text-right">6,900.00</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>2.00</td>
                                                                    <td>SUBFLOOR</td>
                                                                    <td class="text-right">5,800.00</td>
                                                                    <td class="text-right">870.00</td>
                                                                    <td class="text-right">870.00</td>
                                                                    <td class="text-right">15%</td>
                                                                    <td class="text-right">6,670.00</td>
                                                                    <td class="text-right">5,600.00</td>
                                                                    <td class="text-right">6,670.00</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3.00</td>
                                                                    <td>CEILINGS</td>
                                                                    <td class="text-right">6,200.00</td>
                                                                    <td class="text-right">1,240.00</td>
                                                                    <td class="text-right">1,240.00</td>
                                                                    <td class="text-right">20%</td>
                                                                    <td class="text-right">7,440.00</td>
                                                                    <td class="text-right">6,000.00</td>
                                                                    <td class="text-right">7,440.00</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>4.00</td>
                                                                    <td>PARTITIONS</td>
                                                                    <td class="text-right">6,500.00</td>
                                                                    <td class="text-right">975.00</td>
                                                                    <td class="text-right">975.00</td>
                                                                    <td class="text-right">15%</td>
                                                                    <td class="text-right">7,475.00</td>
                                                                    <td class="text-right">6,200.00</td>
                                                                    <td class="text-right">7,475.00</td>
                                                                </tr>

                                                                <!-- CONTINGENCY -->
                                                                <tr>
                                                                    <td colspan="6"><strong>CONTINGENCY</strong></td>
                                                                    <td class="text-right"><strong>1,200.00</strong></td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                </tr>

                                                                <!-- BUILD TOTAL -->
                                                                <tr class="table-success">
                                                                    <td colspan="6"><strong>Build Total ex. VAT</strong></td>
                                                                    <td class="text-right"><strong>29,960.00</strong></td>
                                                                    <td class="text-right"><strong>26,000.00</strong></td>
                                                                    <td class="text-right"><strong>29,960.00</strong></td>
                                                                </tr>

                                                                <!-- VARIATIONS -->
                                                                <tr>
                                                                    <td colspan="9"><strong>Variations</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">VO01 POST CONTRACT VARIATIONS</td>
                                                                    <td class="text-right">6,000.00</td>
                                                                    <td class="text-right">900.00</td>
                                                                    <td class="text-right">900.00</td>
                                                                    <td class="text-right">15%</td>
                                                                    <td class="text-right">6,900.00</td>
                                                                    <td class="text-right">5,800.00</td>
                                                                    <td class="text-right">6,900.00</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
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

// ----------------------------
// SECTION ADD / DELETE
// ----------------------------
function addSection() {
    sectionCount++;
    const sectionHtml = `
        <div class="card mt-3 p-3 section-row">
            <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0 section-label"></label>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteSection(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <input type="hidden" class="section-code" name="sections[${sectionCount}][code]" value="">
            <input type="text" name="sections[${sectionCount}][name]" class="form-control mt-2" placeholder="Enter section name">
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
    const sections = document.querySelectorAll('.section-row');
    sections.forEach((row, index) => {
        const number = (index + 1).toFixed(2);
        row.querySelector('.section-label').innerText = "Section " + number;
        row.querySelector('.section-code').value = number;
    });
}

// ----------------------------
// HELPER FUNCTIONS
// ----------------------------
function parseNumber(value) {
    return parseFloat(value.toString().replace(/,/g, '')) || 0;
}

function formatNumber(value) {
    return parseFloat(value || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// ----------------------------
// CALCULATION LOGIC
// ----------------------------
function calculateRow(row) {
    // Only calculate if the row has necessary fields
    const qtyInput = row.querySelector(".quantity-input");
    const rateInput = row.querySelector(".rate-input");
    const markupInput = row.querySelector(".markup-input");
    const costOutput = row.querySelector(".cost-output");
    const totalOutput = row.querySelector(".total-output");

    if (!qtyInput || !rateInput || !markupInput || !costOutput || !totalOutput) return;

    const qty = parseNumber(qtyInput.value);
    const rate = parseNumber(rateInput.value);
    const markup = parseNumber(markupInput.value);

    const cost = qty * rate;
    const total = cost * (1 + markup / 100);

    costOutput.value = cost.toFixed(2);
    totalOutput.value = total.toFixed(2);
}

// Live calculation on input
document.addEventListener("input", function(e) {
    if (e.target.classList.contains("calc-field")) {
        const row = e.target.closest(".section-item-row");
        if (row) calculateRow(row);
    }
});

// ----------------------------
// COST PLAN SECTION LOGIC
// ----------------------------
document.addEventListener("DOMContentLoaded", function() {
    const costPlanCards = document.querySelectorAll("#costplan .section-card");

    costPlanCards.forEach(sectionCard => {
        const sectionNumber = sectionCard.dataset.section;
        const suppliers = @json($suppliers);

        function updateCostPlanCodes() {
            sectionCard.querySelectorAll(".section-item-row").forEach((row, index) => {
                const codeInput = row.querySelector(".code-input");
                if (codeInput) codeInput.value = sectionNumber + "." + String(index + 1).padStart(2, '0');
            });
        }

        // Add new row
        sectionCard.querySelector(".add-section-item").addEventListener("click", function() {
            const container = sectionCard.querySelector(".section-items");
            const newRow = document.createElement("div");
            newRow.classList.add("form-group", "row", "mb-3", "section-item-row");
            newRow.innerHTML = newRow.innerHTML = `
            <div class="col-md-6 d-flex">
                <div class="short-input me-2">
                    <label>Code</label>
                    <input type="text" class="form-control code-input" readonly>
                </div>
                <div class="col">
                    <label>Item Description</label>
                    <textarea name="item_names[${sectionNumber}][]" class="form-control" rows="4" placeholder="Enter item description"></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row g-2">

                    <div class="col-md-2">
                        <label>Qty</label>
                        <input type="number" name="quantities[${sectionNumber}][]" class="form-control calc-field quantity-input" min="1" value="1">
                    </div>

                    <div class="col-md-2">
                        <label>Unit</label>
                        <input type="text" name="units[${sectionNumber}][]" class="form-control" placeholder="e.g. sqm, lm">
                    </div>

                    <div class="col-md-3">
                        <label>Rate</label>
                        <input type="number" step="0.01" name="rates[${sectionNumber}][]" class="form-control calc-field rate-input" value="0">
                    </div>

                    <div class="col-md-2">
                        <label>Cost</label>
                        <input type="text" name="costs[${sectionNumber}][]" class="form-control cost-output" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Total</label>
                        <input type="text" name="totals[${sectionNumber}][]" class="form-control total-output" readonly>
                    </div>

                    <div class="col-md-3 mt-3">
                        <label>Mark Up %</label>
                        <input type="number" step="0.1" min="0" name="markups[${sectionNumber}][]" class="form-control calc-field markup-input" value="20">
                    </div>

                    <div class="col mt-3">
                        <label>Supplier</label>
                        <select name="suppliers[${sectionNumber}][]" class="form-control">
                            ${suppliers.map(s => `<option value="${s}">${s}</option>`).join('')}
                        </select>
                    </div>

                    <div class="col-auto d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
        `;
            container.appendChild(newRow);
            updateCostPlanCodes();
            calculateRow(newRow);
        });

        // Remove row
        sectionCard.addEventListener("click", e => {
            const btn = e.target.closest(".remove-row");
            if (btn) {
                const row = btn.closest(".section-item-row");
                row.remove();
                updateCostPlanCodes();
            }
        });

        // Calculate all rows initially
        sectionCard.querySelectorAll(".section-item-row").forEach(calculateRow);
        updateCostPlanCodes();
    });

    // Sub total
     function updateSubtotals(sectionCard) {
        let subtotalCost = 0;
        let subtotalTotal = 0;

        sectionCard.querySelectorAll('.section-item-row').forEach(row => {
            const cost = parseFloat(row.querySelector('.cost-output').value) || 0;
            const total = parseFloat(row.querySelector('.total-output').value) || 0;

            subtotalCost += cost;
            subtotalTotal += total;
        });

        const subtotalRow = sectionCard.querySelector('.section-subtotal-row');
        subtotalRow.querySelector('.subtotal-cost').value = subtotalCost.toFixed(2);
        subtotalRow.querySelector('.subtotal-total').value = subtotalTotal.toFixed(2);
    }

    // Initial calculation for all sections
    document.querySelectorAll('.section-card').forEach(sectionCard => {
        updateSubtotals(sectionCard);
    });

    // Recalculate subtotal whenever any input changes
    document.querySelectorAll('.calc-field').forEach(input => {
        input.addEventListener('input', function () {
            const sectionCard = input.closest('.section-card');
            // Recalculate the cost and total if necessary (assuming you have that already)
            const qty = parseFloat(sectionCard.querySelector('.quantity-input').value) || 0;
            const rate = parseFloat(sectionCard.querySelector('.rate-input').value) || 0;
            const markup = parseFloat(sectionCard.querySelector('.markup-input').value) || 0;

            sectionCard.querySelectorAll('.section-item-row').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const rateVal = parseFloat(row.querySelector('.rate-input').value) || 0;
                const markupVal = parseFloat(row.querySelector('.markup-input').value) || 0;

                const cost = quantity * rateVal;
                const total = cost + (cost * markupVal / 100);

                row.querySelector('.cost-output').value = cost.toFixed(2);
                row.querySelector('.total-output').value = total.toFixed(2);
            });

            updateSubtotals(sectionCard);
        });
    });

    

    // Recalculate when adding/removing rows dynamically
    document.querySelectorAll('.add-section-item, .remove-row').forEach(button => {
        button.addEventListener('click', function () {
            const sectionCard = button.closest('.section-card');
            setTimeout(() => updateSubtotals(sectionCard), 100); // delay to allow new row creation/removal
        });
    });

    // ----------------------------
    // VARIATION ORDER LOGIC
    // ----------------------------
    const variationCards = document.querySelectorAll("#section-items-form .section-card");
    variationCards.forEach(sectionCard => {
        const sectionNumber = sectionCard.dataset.section;
        const suppliers = @json($suppliers);

        function updateVariationCodes() {
            sectionCard.querySelectorAll(".section-item-row").forEach((row, index) => {
                const codeInput = row.querySelector(".code-input");
                if (codeInput) codeInput.value = sectionNumber + "." + String(index + 1).padStart(2, '0');
            });
        }

        sectionCard.querySelector(".add-section-item").addEventListener("click", function() {
            const container = sectionCard.querySelector(".section-items");
            const newRow = document.createElement("div");
            newRow.classList.add("form-group", "row", "mb-3", "section-item-row");
            newRow.innerHTML = `
                <div class="col-md-1">
                    <label>Code</label>
                    <input type="text" class="form-control code-input" readonly>
                </div>
                <div class="col-md-5">
                    <label>Item Description</label>
                    <input type="text" name="item_names[${sectionNumber}][]" class="form-control" placeholder="Enter item description">
                </div>
                <div class="col-md-1">
                    <label>Quantity</label>
                    <input type="number" name="quantities[${sectionNumber}][]" class="form-control quantity-input calc-field" min="1" value="1">
                </div>
                <div class="col-md-1">
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

        sectionCard.addEventListener("click", e => {
            const btn = e.target.closest(".remove-row");
            if (btn) {
                btn.closest(".section-item-row").remove();
                updateVariationCodes();
            }
        });

        updateVariationCodes();
    });

});

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.section-markup-input').forEach(function (headerInput) {

        headerInput.addEventListener('input', function () {
            const sectionId = this.dataset.sectionId;
            const newMarkup = this.value;

            const sectionCard = document.querySelector(
                '.section-card[data-section="' + sectionId + '"]'
            );

            if (!sectionCard) return;

            sectionCard.querySelectorAll('.markup-input').forEach(function (itemInput) {
                itemInput.value = newMarkup;

                // 🔥 Force all listeners to fire
                itemInput.dispatchEvent(new Event('input', { bubbles: true }));
                itemInput.dispatchEvent(new Event('change', { bubbles: true }));
                itemInput.dispatchEvent(new Event('keyup', { bubbles: true }));
            });
        });

    });

});
</script>

    <style>
        .short-input {
            width: 65px;
        }
        .section-item-row {
            border-bottom: 1px solid #ddd;
            padding-bottom: 25px;
        }
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
