@extends('pages.projects.form')
@section('cost-plan-tab')
    <form action="{{ route('section_items.store') }}" method="POST">
        @csrf

        @foreach ($templateSections as $sectionIndex => $section)
            <div class="card card-primary card-outline mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" data-toggle="collapse"
                    data-target="#section-{{ $section->id }}" aria-expanded="true" aria-controls="section-{{ $section->id }}"
                    style="cursor:pointer;">

                    <h5 class="card-title mb-0">
                        {{ $section->section_code }} -
                        {{ $section->section_name }}
                    </h5>

                    <div class="d-flex align-items-center ml-auto" onclick="event.stopPropagation();">
                        <label class="mb-0 me-2"><strong>Mark Up % &nbsp;
                            </strong></label>
                        <input type="number" step="0.1" min="0" class="form-control section-markup-input"
                            style="width:90px;" data-section-id="{{ $section->id }}" value="20">
                    </div>
                </div>

                <div id="section-{{ $section->id }}" class="collapse show">


                    <div class="card-body section-card" data-section="{{ $section->id }}">
                        <div class="section-items">

                            {{-- Preloaded template items --}}
                            @foreach ($section->items as $item)
                                <div class="form-group row mb-3 section-item-row">

                                    <div class="col-md-6 d-flex">
                                        <div class="short-input">
                                            <label>Code</label>
                                            <input type="text" name="codes[{{ $section->id }}][]"
                                                class="form-control code-input" readonly value="{{ $item->item_code }}">
                                        </div>

                                        <div class="col">
                                            <label>Item Description</label>
                                            <textarea name="item_names[{{ $section->id }}][]" class="form-control " rows="4">{{ $item->description }}</textarea>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row g-2">

                                            <!-- Qty (small auto width) -->
                                            <div class="col-md-2">
                                                <label>Qty</label>
                                                <input type="number" name="quantities[{{ $section->id }}][]"
                                                    class="form-control calc-field quantity-input" min="1"
                                                    value="{{ $item->quantity }}">
                                            </div>

                                            <!-- Unit (small auto width) -->
                                            <div class="col-md-2">
                                                <label>Unit</label>
                                                <input type="text" name="units[{{ $section->id }}][]"
                                                    class="form-control" value="{{ $item->unit }}">
                                            </div>

                                            <!-- Rate (small auto width) -->
                                            <div class="col-md-3">
                                                <label>Rate</label>
                                                <input type="number" step="0.01" name="rates[{{ $section->id }}][]"
                                                    class="form-control calc-field rate-input" value="{{ $item->rate }}">
                                            </div>

                                            <!-- Cost (auto-expand) -->
                                            <div class="col-md-2">
                                                <label>Cost</label>
                                                <input type="text" name="costs[{{ $section->id }}][]"
                                                    class="form-control cost-output" readonly>
                                            </div>

                                            <!-- Total (auto-expand) -->
                                            <div class="col-md-2">
                                                <label>Total</label>
                                                <input type="text" name="totals[{{ $section->id }}][]"
                                                    class="form-control total-output" readonly>
                                            </div>

                                            <!-- Markup (small auto width) -->
                                            <div class="col-md-3 mt-3">
                                                <label>Mark Up %</label>
                                                <input type="number" step="0.1" min="0"
                                                    name="markups[{{ $section->id }}][]"
                                                    class="form-control calc-field markup-input" value="20">
                                            </div>

                                            <!-- Supplier (full width on wrap) -->
                                            <div class="col-md-8 mt-3">
                                                <label>Supplier</label>

                                                <select name="suppliers[{{ $section->id }}]"
                                                    class="form-control select2bs4">
                                                    <option value="">Select
                                                        Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            @if (old('suppliers.' . $section->id) == $supplier->id) selected @endif>
                                                            {{ $supplier->business_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Purchase Order Number -->
                                            <div class="col-md-3 mt-3">
                                                <label>PO Number</label>
                                                <input type="text" name="po_numbers[{{ $section->id }}][]"
                                                    class="form-control" placeholder="PO-001">
                                            </div>

                                            <!-- Purchase Order Value -->
                                            <div class="col-md-3 mt-3">
                                                <label>PO Value</label>
                                                <input type="number" step="0.01"
                                                    name="po_values[{{ $section->id }}][]" class="form-control"
                                                    placeholder="0.00">
                                            </div>

                                            <!-- Invoice Reference Number -->
                                            <div class="col-md-3 mt-3">
                                                <label>Invoice Ref</label>
                                                <input type="text" name="invoice_refs[{{ $section->id }}][]"
                                                    class="form-control" placeholder="INV-001">
                                            </div>

                                            <!-- Invoice Value -->
                                            <div class="col-md-3 mt-3">
                                                <label>Invoice Value</label>
                                                <input type="number" step="0.01"
                                                    name="invoice_values[{{ $section->id }}][]" class="form-control"
                                                    placeholder="0.00">
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
                        <button type="button" class="btn btn-primary add-section-item mb-3"
                            data-section-id="{{ $section->id }}" data-section-code="{{ $section->section_code }}">
                            <i class="fas fa-plus"></i>&nbsp; Add Item
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Save All Sections</button>
    </form>
@endsection
