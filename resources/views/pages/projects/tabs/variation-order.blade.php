@extends('pages.projects.form')
@section('variation-order-tab')
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
                        '8.00 Finishes & Painting',
                    ];
                @endphp
                @foreach ($items as $item)
                    <label class="d-flex align-items-center mb-2 selectable-label">
                        <div class="select-box mr-2" onclick="toggleBox(this)">
                        </div>
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
                    $sections = ['2.00 Subfloor', '3.00 Ceiling Works', '4.00 Partitions & Walls'];

                    $section2Items = [
                        'Take up raised floor panels for access to the services in the floor void and re-lay on completion.',
                        'Create new cut out for new floor boxes/grommets.',
                        'Repair damaged raised floor panels and ensure level finish.',
                        'Supply and install new raised access floor panels to match existing.',
                    ];
                @endphp

                @foreach ($sections as $index => $section)
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h5 class="card-title">{{ $section }}</h5>
                        </div>
                        <div class="card-body section-card" data-section="{{ $index + 2 }}">
                            <div class="section-items">

                                @if ($index === 0)
                                    @foreach ($section2Items as $itemIndex => $item)
                                        <div class="form-group row mb-3 section-item-row">
                                            <div class="col-md-1">
                                                <label>Code</label>
                                                <input type="text" name="codes[{{ $index }}][]"
                                                    class="form-control code-input" readonly
                                                    value="2.{{ sprintf('%02d', $itemIndex + 1) }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Item Description</label>
                                                <input type="text" name="item_names[{{ $index }}][]"
                                                    class="form-control" value="{{ $item }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Quantity</label>
                                                <input type="number" name="quantities[{{ $index }}][]"
                                                    class="form-control" min="1" value="1">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Unit</label>
                                                <input type="text" name="units[{{ $index }}][]"
                                                    class="form-control" placeholder="e.g. sqm, lm">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Supplier</label>
                                                <select name="suppliers[{{ $index }}][]" class="form-control">
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier }}">
                                                            {{ $supplier }}
                                                        </option>
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
                                            <input type="text" name="codes[{{ $index }}][]"
                                                class="form-control code-input" readonly value="{{ $index + 1 }}.01">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Item Description</label>
                                            <input type="text" name="item_names[{{ $index }}][]"
                                                class="form-control" placeholder="Enter item description">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Quantity</label>
                                            <input type="number" name="quantities[{{ $index }}][]"
                                                class="form-control" min="1" value="1">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Unit</label>
                                            <input type="text" name="units[{{ $index }}][]" class="form-control"
                                                placeholder="e.g. sqm, lm">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Supplier</label>
                                            <select name="suppliers[{{ $index }}][]" class="form-control">
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier }}">
                                                        {{ $supplier }}
                                                    </option>
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
@endsection
