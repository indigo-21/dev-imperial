<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($project) ? 'Edit' : 'Create' }} Variation Order
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Variation Order Details</h3>
                    </div>
                    <form action="{{ isset($project) ? route('costPlans.update', $project->id) : route('costPlans.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($project))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Project</label>
                                        <select class="form-control select2bs4" name="project_id" style="width: 100%;">
                                            <option value="">-- Select Project --</option>
                                            <option value="1">Project Alpha</option>
                                            <option value="2">Project Beta</option>
                                            <option value="3">Project Gamma</option>
                                            <option value="4">Project Delta</option>
                                        </select>
                                    </div>

                                     <div class="form-group">
                                            <label for="variation_order">Variation Order</label>
                                            <input type="text" name="variation_order" class="form-control" id="variation_order">
                                        </div>

                                    <div class="form-group">
                                        <label>Project Scope Template</label>
                                        <select class="form-control select2bs4" id="project-template" name="project-template" style="width: 100%;">
                                            <option value="">-- Select Project Scope Template--</option>
                                            <option value="1">Template 1</option>
                                            <option value="2">Template 2</option>
                                        </select>
                                    </div>

                                    <!-- Hidden card that will display template details -->
                                    <div id="template-details" class="card mt-3" style="display: none;">
                                        <div class="card-header">
                                            <h5 class="card-title">Project Scope</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group">
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
                                                        <input type="hidden" name="scope_items[]" value="{{ $item }}">
                                                        <span>{{ $item }}</span>
                                                    </label>
                                                @endforeach
                                            </div>

                                            <a href="{{ route('section_items.edit', 1) }}" class="float-right btn btn-success mt-3" id="proceed-link">
                                                Proceed
                                            </a>
                                        </div>
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
    <script>
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#project-template').on('change', function () {
                let selected = $(this).val();
                if (selected === "1") {
                    $('#template-details').slideDown();
                } else {
                    $('#template-details').slideUp();
                }
            });
        });

        function toggleBox(box) {
            box.classList.toggle('selected');
            let input = box.nextElementSibling; // hidden input
            input.disabled = !input.disabled;
        }
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
