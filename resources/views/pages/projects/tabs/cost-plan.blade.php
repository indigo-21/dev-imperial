@extends('pages.projects.form')

@section('cost-plan-tab')
    <form id="cost_plan_form" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{$project->id}}">
        @foreach ($cost_plan as $section_index => $cost_plan_section )
            <div class="card card-primary card-outline item-container mb-4 section-container">
                <div class="card-header d-flex justify-content-between align-items-center" data-toggle="collapse"
                    data-target="#section-{{$cost_plan_section->id}}" aria-expanded="true"
                    aria-controls="section-{{$cost_plan_section->id}}" style="cursor:pointer;">

                    <h5 class="card-title mb-0 w-50">
                        <input type="hidden" name="section_id" value="{{ $has_costplan ? $cost_plan_section->id : '' }}">
                        <input type="hidden" name="section_code" value="{{$cost_plan_section->section_code}}">
                        <input type="hidden" name="section_name" value="{{$cost_plan_section->section_name}}">
                        {{$cost_plan_section->section_code}} -
                        {{$cost_plan_section->section_name}}
                    </h5>

                    <div class="d-flex justify-content-end align-items-center ml-auto w-50" onclick="event.stopPropagation(200);">
                        <div class="mark-up-section mx-5 d-flex align-items-center">
                            <label class="mb-0 me-2"><strong>Mark Up % &nbsp;</strong></label>
                            <input type="number" step="1" min="0" class="form-control section-markup-input"
                            style="width:90px;" data-section-id="test-id" name="section_markup" value="{{ $cost_plan_section?->mark_up ?? "20" }}">
                        </div>
                    </div>
                </div>

                <div id="section-{{$cost_plan_section->id}}" class="collapse show">
                    <div class="card-body section-card drag-drop-sortable drag-drop-sortable-{{$section_index}}" data-section="{{$section_index}}">
                        @foreach ($cost_plan_section->items as $item_index => $cost_plan_item )
                            <div class="section-items">
                                <input type="hidden" name="item_id" value="{{ $has_costplan ? $cost_plan_item->id : '' }}">
                                <div class="form-group row mb-3 section-item-row">
                                    <div class="col-md-6 d-flex">
                                        <div class="short-input">
                                            <label>Code</label>
                                            <input type="text" name="item_code"
                                                class="form-control code-input" readonly value="{{ $cost_plan_item->item_code }}">
                                        </div>

                                        <div class="col form-group">
                                            <label>Item Description</label>
                                            <textarea required name="description" class="form-control item-description" rows="10">{{$cost_plan_item->description}}</textarea>
                                            <span class="text-danger item-description-error error"></span>
                                        </div>

                                    </div>

                                    <div class="col-md-6 row">
                                        <div class="col-12 row">
                                            <div class="col-md-2">
                                                <label>Qty</label>
                                                <input type="number" name="quantity"
                                                    class="form-control calc-field item-input quantity-input" min="0" step="1"
                                                    value="{{$cost_plan_item->quantity}}">
                                            </div>

                                            <div class="col-md-2">
                                                <label>Unit</label>
                                                <select name="unit" class="form-control unit-input">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit }}"
                                                            {{ old('unit', $cost_plan_item->unit ?? 'item') == $unit ? 'selected' : '' }}>
                                                            {{ $unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Rate</label>
                                                <input type="number" step="0.01" name="rate" step="1"
                                                    class="form-control calc-field item-input rate-input" value="{{$cost_plan_item->rate}}">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Cost</label>
                                                <input type="text" name="cost" value="{{ $cost_plan_item?->cost ?? "100"}}"
                                                    class="form-control cost-output" readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Total</label>
                                                <input type="text" name="total"
                                                    class="form-control total-output" readonly value="{{$cost_plan_item?->total ?? "0.00"}}">
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-md-4 mt-3">
                                                <label>Mark Up %</label>
                                                <input type="number" step="0.5" min="0"
                                                    name="mark_up"
                                                    class="form-control calc-field item-input markup-input" value="{{$cost_plan_item?->mark_up ?? "20"}}">
                                            </div>
                                            <div class="col-md-8 mt-3">
                                                <label>Supplier</label>
                                                @php
                                                    $old_supplier_id = $cost_plan_item?->supplier_id ?? null;
                                                @endphp
                                                <select name="supplier_id"
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

                        {{-- Add new item --}}
                        <button type="button" class="btn btn-primary add-section-item mb-3"
                            data-section-id="test-id" data-section-code="section-code">
                            <i class="fas fa-plus"></i>&nbsp; Add Item
                        </button>

                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="left w-50 text-start">
                        <button type="button" class="btn btn-danger ml-3 remove-all-items">
                            <i class="fas fa-trash"></i> Remove all Items
                        </button>
                    </div>
                    {{-- Subtotal row --}}
                    <div class="form-group row mb-3 section-subtotal-row d-flex justify-content-end align-items-center w-50">
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
                </div>
            </div>
        @endforeach

        <button type="button" class="btn btn-success cost-plan-submit" id="cost-plan-submit-button">{{ count($has_cost_plan) ? "Update" : "Save" }} Cost Plan</button>
        
    </form>
    <!-- Scroll to Bottom Button -->
    <button id="scrollToBottom" title="Go to bottom">
        <i class="fas fa-arrow-down"></i>
    </button>
@endsection

@section('scripts')
    <script src="{{ asset('assets/custom/js/pages/projects/tabs/cost-plan.js') }}?v={{ time() }}"></script>
    <script>
        $(document).ready(function() {
            const SECTION_COUNT = $(".section-card").length;
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: "Select Supplier",
                allowClear: true
            });

            const scrollBtn = $('#scrollToBottom');

            scrollBtn.on('click', function() {
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 600);
            });

            $(window).on('scroll', function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                    scrollBtn.fadeOut();
                } else {
                    scrollBtn.fadeIn();
                }
            });

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                scrollBtn.hide();
            }

            for (let index = 0; index < SECTION_COUNT; index++) {
                $(`.drag-drop-sortable-${index}`).sortable({
                    connectWith: `.drag-drop-sortable-${index}`,
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true
                }).disableSelection();
            }
            
        });
    </script>

@endsection
