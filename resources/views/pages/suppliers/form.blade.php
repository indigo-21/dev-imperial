<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($supplier) ? 'Edit' : 'Create' }} Sub Contractor / Supplier
    </x-slot>

    <x-slot name="content">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST">
                    @csrf
                    @if (isset($supplier))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Business Name</label>
                                <input type="text" name="business_name" class="form-control" placeholder="Enter business name">
                            </div>

                            <div class="form-group">
                                <label>Business Address</label>
                                <textarea name="business_address" class="form-control" rows="3" placeholder="Enter business address"></textarea>
                            </div>

                            <div class="form-group">
                                <label>UTR (Unique Tax Reference)</label>
                                <input type="text" name="utr" class="form-control" placeholder="Enter UTR">
                            </div>

                            <div class="form-group">
                                <label>Company Registration Number</label>
                                <input type="text" name="company_reg" class="form-control" placeholder="Enter registration number">
                            </div>

                            <div class="form-group">
                                <label>VAT Number</label>
                                <input type="text" name="vat_number" class="form-control" placeholder="Enter VAT number">
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-6">
                            <!-- CONTACT GROUP -->
                            <div class="form-group">
                                <label>Contact Information</label>
                                <div id="contact-group">
                                    <div class="contact-info-group d-flex mb-2">
                                        <input type="text" name="contacts[0][name]" class="form-control mr-2" placeholder="Contact Name" required>
                                        <input type="text" name="contacts[0][mobile]" class="form-control mr-2" placeholder="Mobile Number">
                                        <input type="text" name="contacts[0][email]" class="form-control mr-2" placeholder="Email Address">
                                        <div class="contact-info-group-append">
                                            <button type="button" class="btn btn-success" onclick="addContact()"> <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SUPPLIER TYPE -->
                            <div class="form-group">
                                <label>Supplier Type</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle w-100 text-left" type="button"
                                        id="supplierDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select Supplier Type(s)
                                    </button>
                                    <div class="dropdown-menu w-100 p-2" aria-labelledby="supplierDropdown"
                                         style="max-height: 300px; overflow-y: auto;">
                                        <!-- Search box -->
                                        <div class="form-group mb-2">
                                            <input type="text" id="supplierSearch" class="form-control"
                                                placeholder="Search supplier type...">
                                        </div>
                                        <div id="supplierList">
                                            @php
                                                $types = [
                                                    'Asbestos', 'AV', 'Builders Work', 'Building Control Inspector', 'Carpentry',
                                                    'Cleaning', 'Data', 'Decorator', 'Demolition', 'Design', 'Dry Lining',
                                                    'Electrical', 'Fire Safety', 'Flooring', 'Furniture', 'Glazed Partitioning',
                                                    'Health & Safety', 'Joiner', 'Labourer', 'Lighting', 'Mastic', 'Mechanical',
                                                    'Plumber', 'Security', 'Signage/Manifestation', 'Site Supervisor',
                                                    'Tiling', 'Waste Clearance'
                                                ];
                                            @endphp

                                            @foreach ($types as $type)
                                                <div class="form-check">
                                                    <input class="form-check-input supplier-checkbox" type="checkbox"
                                                        value="{{ $type }}" id="type_{{ $loop->index }}" name="supplier_types[]">
                                                    <label class="form-check-label" for="type_{{ $loop->index }}">{{ $type }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label>Public Liability Insurance Cover Value</label>
                                <input type="text" name="insurance_cover" class="form-control" placeholder="Enter cover value">
                            </div>

                            <div class="form-group">
                                <label>Insurance Policy Expiry</label>
                                <input type="date" name="insurance_expiry" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    {{-- <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div> --}}
                </form>
            </div>
        </div>
    </x-slot>

    @section('scripts')
    <script>
        let contactIndex = 1;

        function addContact() {
            const group = document.createElement('div');
            group.classList.add('contact-info-group', 'mb-2', 'd-flex');
            group.innerHTML = `
                <input type="text" name="contacts[${contactIndex}][name]" class="form-control mr-2" placeholder="Contact Name" required>
                <input type="text" name="contacts[${contactIndex}][mobile]" class="form-control mr-2" placeholder="Mobile Number">
                <input type="text" name="contacts[${contactIndex}][email]" class="form-control mr-2" placeholder="Email Address">
                <div class="contact-info-group-append">
                    <button type="button" class="btn btn-danger" onclick="removeContact(this)"><i class="fa fa-minus"></i></button>
                </div>`;
            document.getElementById('contact-group').appendChild(group);
            contactIndex++;
        }

        function removeContact(button) {
            button.closest('.contact-info-group').remove();
        }

        // Update dropdown button text with selected types
        $(document).on('change', '.supplier-checkbox', function () {
            const selected = [];
            $('.supplier-checkbox:checked').each(function () {
                selected.push($(this).val());
            });
            $('#supplierDropdown').text(selected.length ? selected.join(', ') : 'Select Supplier Type(s)');
        });

        // Supplier search filter
        $('#supplierSearch').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#supplierList .form-check').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    </script>
    @endsection
</x-app-layout>
