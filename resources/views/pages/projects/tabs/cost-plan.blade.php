@extends('pages.projects.form')
@section('cost-plan-tab')
    <form id="cost_plan_form" action="{{ route('projects.costplan_store') }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}">
        @foreach ($cost_plan as $section_index => $cost_plan_section )
            <div class="card card-primary card-outline item-container mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" data-toggle="collapse"
                    data-target="#section-{{$cost_plan_section->id}}" aria-expanded="true"
                    aria-controls="section-{{$cost_plan_section->id}}" style="cursor:pointer;">

                    <h5 class="card-title mb-0">
                        <input type="hidden" name="section_code[{{$section_index}}]" value="{{$cost_plan_section->section_code}}">
                        <input type="hidden" name="section_name[{{$section_index}}]" value="{{$cost_plan_section->section_name}}">
                        {{$cost_plan_section->section_code}} -
                        {{$cost_plan_section->section_name}}
                    </h5>

                    <div class="d-flex align-items-center ml-auto" onclick="event.stopPropagation(200);">
                        <div class="adjudication-section d-flex align-items-center">
                            <div class="mark-up-section d-flex align-items-center">
                                <label class="mb-0 me-2"><strong>Adjudication&nbsp;</strong></label>
                                @php
                                    $adjudication = $cost_plan_section->for_adjudication;
                                @endphp
                                 <select name="adjudication[{{$section_index}}]" class="form-control select2bs4" id="adjudication" style="width:100px;">
                                     <option {{$adjudication == 0 ? "selected": ""}} value="0">No</option>
                                     <option {{$adjudication == 1 ? "selected": ""}} value="1">Yes</option>
                                </select> 
                            </div>
                        </div>
                        <div class="mark-up-section mx-5 d-flex align-items-center">
                            <label class="mb-0 me-2"><strong>Mark Up % &nbsp;</strong></label>
                            <input type="number" step="0.1" min="0" class="form-control section-markup-input"
                            style="width:90px;" data-section-id="test-id" name="section_markup[{{$section_index}}]" value="{{ $cost_plan_section?->mark_up ?? "20" }}">
                        </div>
                    </div>
                </div>

                <div id="section-{{$cost_plan_section->id}}" class="collapse show">
                    <div class="card-body section-card" data-section="{{$section_index}}">
                        @foreach ($cost_plan_section->items as $item_index => $cost_plan_item )
                            <div class="section-items">
                                <div class="form-group row mb-3 section-item-row">

                                    <div class="col-md-6 d-flex">
                                        <div class="short-input">
                                            <label>Code</label>
                                            <input type="text" name="item_code[{{$section_index}}][{{$item_index}}]"
                                                class="form-control code-input" readonly value="{{ $cost_plan_item->item_code }}">
                                        </div>

                                        <div class="col">
                                            @php
                                                $description_name = "description[$section_index][$item_index]";
                                            @endphp
                                            <label>Item Description</label>
                                            <textarea required name="{{$description_name}}" class="form-control item-description" rows="10">{{$cost_plan_item->description}}</textarea>
                                            <span class="text-danger error">{{ $errors->first($description_name) }}</span>
                                        </div>

                                    </div>

                                    <div class="col-md-6 row">
                                        <div class="col-12 row">
                                            <div class="col-md-2">
                                                <label>Qty</label>
                                                <input type="number" name="quantity[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control calc-field item-input quantity-input" min="1"
                                                    value="{{$cost_plan_item->quantity}}">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Unit</label>
                                                <input type="text" name="unit[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control unit-input" value="{{$cost_plan_item->unit}}">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Rate</label>
                                                <input type="number" step="0.01" name="rate[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control calc-field item-input rate-input" value="{{$cost_plan_item->rate}}">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Cost</label>
                                                <input type="text" name="cost[{{$section_index}}][{{$item_index}}]" value="{{ $cost_plan_item?->cost ?? "100"}}"
                                                    class="form-control cost-output" readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Total</label>
                                                <input type="text" name="total[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control total-output" readonly value="{{$cost_plan_item?->total ?? "0.00"}}">
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-md-4 mt-3">
                                                <label>Mark Up %</label>
                                                <input type="number" step="0.1" min="0"
                                                    name="mark_up[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control calc-field item-input markup-input" value="{{$cost_plan_item?->mark_up ?? "20"}}">
                                            </div>
                                            <div class="col-md-8 mt-3">
                                                <label>Supplier</label>
                                                @php
                                                    $old_supplier_id = $cost_plan_item?->supplier_id ?? null;
                                                @endphp
                                                <select name="supplier_id[{{$section_index}}][{{$item_index}}]"
                                                    class="form-control select2bs4">
                                                    <option value="">Select
                                                        Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                           <option 
                                                                {{$old_supplier_id == $supplier->id ? "selected" : ""}}
                                                                value="{{$supplier->id}}">
                                                                {{$supplier->business_name}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <!-- Remove row button -->
                                            <div class="col-12 d-flex align-item-center justify-content-center py-3">
                                                <button type="button" class="btn btn-danger w-50 remove-row">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

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
                        <button type="button" class="btn btn-primary add-section-item mb-3"
                            data-section-id="test-id" data-section-code="section-code">
                            <i class="fas fa-plus"></i>&nbsp; Add Item
                        </button>

                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">{{ count($has_cost_plan) ? "Update" : "Save" }} Cost Plan</button>
        
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/cost-plan.js') }}"></script>
@endsection
