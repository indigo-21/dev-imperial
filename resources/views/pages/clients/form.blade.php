<x-app-layout>
    <x-slot name="pageTitle">
        Create Client
    </x-slot>

    <x-slot name="content">
        <div class="row">
            <!-- LEFT CARD -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Client Information</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" name="business_name" id="business_name" class="form-control" required>
                        </div>

                        <!-- CONTACT INFORMATION -->
                        <div class="form-group">
                            <label>Contact Information</label>
                            <div id="contact-info-wrapper">
                                <div class="d-flex mb-2 contact-info-group">
                                    <input type="text" name="contacts[0][name]" class="form-control mr-2" placeholder="Contact Name" required>
                                    <input type="text" name="contacts[0][mobile]" class="form-control mr-2" placeholder="Mobile Number">
                                    <input type="text" name="contacts[0][email]" class="form-control mr-2" placeholder="Email Address">
                                    <button type="button" class="btn btn-success add-contact">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="business_address">Business Address</label>
                            <textarea name="business_address" id="business_address" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT CARD -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Company Details</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="utr">UTR (Unique Tax Reference)</label>
                            <input type="text" name="utr" id="utr" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="company_reg_no">Company Registration Number</label>
                            <input type="text" name="company_reg_no" id="company_reg_no" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="vat_number">VAT Number</label>
                            <input type="text" name="vat_number" id="vat_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="client_type">Client Type</label>
                            <select name="client_type" id="client_type" class="form-control" required>
                                <option value="">-- Select Client Type --</option>
                                <option value="Landlord">Landlord</option>
                                <option value="Occupier">Occupier</option>
                            </select>
                        </div>

                        {{-- Industries Dropdown (hidden by default) --}}
                        <div class="form-group" id="industries-group" style="display: none;">
                            <label for="industry">Industry</label>
                            <select name="industry" id="industry" class="form-control">
                                <option value="">-- Select Industry --</option>
                                @php
                                    $industries = [
                                        'Accountancy',
                                        'Advertising Agency',
                                        'Architecture',
                                        'Charity',
                                        'Construction',
                                        'Data Centres',
                                        'E-commerce',
                                        'Education',
                                        'Engineering',
                                        'Entertainment Business',
                                        'Fashion',
                                        'Financial Services',
                                        'Fintech Companies',
                                        'Government/Local Councils',
                                        'Healthcare',
                                        'Hospitability',
                                        'IT',
                                        'Insurance',
                                        'Legal',
                                        'Leisure',
                                        'Logistics',
                                        'Manufacturing',
                                        'Marketing/PR',
                                        'Media',
                                        'Property/Real Estate',
                                        'Recruitment',
                                        'Travel'
                                    ];
                                    $selectedIndustry = old('industry', $client->industry ?? '');
                                @endphp

                                @foreach($industries as $industry)
                                    <option value="{{ $industry }}" {{ $selectedIndustry == $industry ? 'selected' : '' }}>
                                        {{ $industry }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Client</button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('contact-info-wrapper');
            let contactIndex = 1;

            wrapper.addEventListener('click', function(e) {
                // Add new contact row
                if (e.target.closest('.add-contact')) {
                    e.preventDefault();
                    const newRow = document.createElement('div');
                    newRow.classList.add('d-flex', 'mb-2', 'contact-info-group');
                    newRow.innerHTML = `
                        <input type="text" name="contacts[${contactIndex}][name]" class="form-control mr-2" placeholder="Contact Name" required>
                        <input type="text" name="contacts[${contactIndex}][mobile]" class="form-control mr-2" placeholder="Mobile Number">
                        <input type="text" name="contacts[${contactIndex}][email]" class="form-control mr-2" placeholder="Email Address">
                        <button type="button" class="btn btn-danger remove-contact"><i class="fa fa-minus"></i></button>
                    `;
                    wrapper.appendChild(newRow);
                    contactIndex++;
                }

                // Remove contact row
                if (e.target.closest('.remove-contact')) {
                    e.preventDefault();
                    e.target.closest('.contact-info-group').remove();
                }
            });

            const clientType = document.getElementById('client_type');
            const industriesGroup = document.getElementById('industries-group');

            // Show on load if Occupier is already selected
            if (clientType.value === 'Occupier') {
                industriesGroup.style.display = 'block';
            }

            clientType.addEventListener('change', function() {
                if (this.value === 'Occupier') {
                    industriesGroup.style.display = 'block';
                } else {
                    industriesGroup.style.display = 'none';
                    document.getElementById('industry').value = '';
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
