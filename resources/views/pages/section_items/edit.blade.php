<x-app-layout>
    <x-slot name="pageTitle">
        Edit Section Items
    </x-slot>
    <x-slot name="content">
        <form action="{{ route('section_items.store') }}" method="POST">
            @csrf
            @php
                $sections = [
                    '2.00 Subfloor',
                    '3.00 Ceiling Works',
                    '4.00 Partitions & Walls'
                    
                ];

                // Predefined items for section 2
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
                    <div class="card-body section-card" data-section="{{ $index + 1 }}">
                        <div class="section-items">

                            @if($index === 0) {{-- Section 2 --}}
                                @foreach($section2Items as $itemIndex => $item)
                                    <div class="form-group row mb-3 section-item-row">
                                        <div class="col-md-2">
                                            <label>Code</label>
                                            <input type="text" name="codes[{{ $index }}][]" class="form-control code-input" readonly value="2.{{ sprintf('%02d', $itemIndex + 1) }}">
                                        </div>
                                        <div class="col-md-4">
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
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-row">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="form-group row mb-3 section-item-row">
                                    <div class="col-md-2">
                                        <label>Code</label>
                                        <input type="text" name="codes[{{ $index }}][]" class="form-control code-input" readonly value="{{ $index + 1 }}.01">
                                    </div>
                                    <div class="col-md-4">
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
                                    <div class="col-md-2 d-flex align-items-end">
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

            <button type="submit" class="btn btn-success mb-2">Save All Sections</button>
        </form>
    </x-slot>

    @section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            function updateCodes(sectionCard) {
                let sectionNumber = sectionCard.dataset.section;
                let rows = sectionCard.querySelectorAll(".section-item-row");
                rows.forEach((row, index) => {
                    let codeInput = row.querySelector(".code-input");
                    let codeNumber = index + 1;
                    codeInput.value = sectionNumber + "." + String(codeNumber).padStart(2, '0');
                });
            }

            // Add new item
            document.querySelectorAll(".add-section-item").forEach(btn => {
                btn.addEventListener("click", function () {
                    let sectionCard = btn.closest(".section-card");
                    let container = sectionCard.querySelector(".section-items");

                    let newRow = document.createElement("div");
                    newRow.classList.add("form-group", "row", "mb-3", "section-item-row");
                    newRow.innerHTML = `
                        <div class="col-md-2">
                            <label>Code</label>
                            <input type="text" name="codes[]" class="form-control code-input" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Item Description</label>
                            <input type="text" name="item_names[]" class="form-control" placeholder="Enter item description">
                        </div>
                        <div class="col-md-2">
                            <label>Quantity</label>
                            <input type="number" name="quantities[]" class="form-control" min="1" value="1">
                        </div>
                        <div class="col-md-2">
                            <label>Unit</label>
                            <input type="text" name="units[]" class="form-control" placeholder="e.g. sqm, lm">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    container.appendChild(newRow);
                    updateCodes(sectionCard);
                });
            });

            // Remove row
            document.querySelectorAll(".section-card").forEach(sectionCard => {
                sectionCard.addEventListener("click", function (e) {
                    if (e.target.closest(".remove-row")) {
                        e.target.closest(".section-item-row").remove();
                        updateCodes(sectionCard);
                    }
                });
            });

            // Initial codes update
            document.querySelectorAll(".section-card").forEach(sectionCard => {
                updateCodes(sectionCard);
            });

        });
    </script>
    @endsection
</x-app-layout>
