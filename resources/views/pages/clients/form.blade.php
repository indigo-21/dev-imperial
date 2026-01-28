<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($client) ? 'Edit' : 'Create' }} Client
    </x-slot>

    <x-slot name="content">


        <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" method="POST">
            @csrf
            @if(isset($client))
                @method('PUT')
            @endif

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
                                @php
                                    $contacts = old('contacts', $client->contacts ?? [['name'=>'','phone'=>'','email'=>'']]);
                                @endphp
                                @foreach($contacts as $index => $contact)
                                    <div class="d-flex mb-2 contact-info-group">
                                        <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact['id'] ?? '' }}">
                                        <input type="text" name="contacts[{{ $index }}][name]" class="form-control mr-2" placeholder="Contact Name" value="{{ $contact['name'] ?? $contact['contact_name'] ?? '' }}" required>
                                        <input type="text" name="contacts[{{ $index }}][phone]" class="form-control mr-2" placeholder="Phone Number" value="{{ $contact['phone'] ?? $contact['phone'] ?? '' }}">
                                        <input type="text" name="contacts[{{ $index }}][email]" class="form-control mr-2" placeholder="Email Address" value="{{ $contact['email'] ?? '' }}">
                                        @if($index === 0)
                                            <button type="button" class="btn btn-success add-contact">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger remove-contact">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
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
                            <input type="text" name="unique_tax_reference" id="utr" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="company_reg_no">Company Registration Number</label>
                            <input type="text" name="company_registration_number" id="company_reg_no" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="vat_number">VAT Number</label>
                            <input type="text" name="vat_number" id="vat_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="client_type_id">Client Type</label>
                            <select name="client_type_id" id="client_type_id" class="form-control" required>
                                <option value="">-- Select Client Type --</option>
                            
                                @foreach ($clientTypes as $clientType)
                                    <option value="{{ $clientType->id }}"
                                            data-name="{{ $clientType->name }}">
                                        {{ $clientType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Industries Dropdown (hidden by default) --}}
                        <div class="form-group" id="industries-group" style="display: none;">
                            <label for="industry">Industry</label>
                            <select name="industry" id="industry" class="form-control select2">
                                <option value="">-- Select Industry --</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}"
                                        {{ old('industry', $client->industry ?? '') == $industry ? 'selected' : '' }}>
                                        {{ $industry }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ isset($client) ? 'Update' : 'Create' }} Client</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
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
                        <input type="text" name="contacts[${contactIndex}][phone]" class="form-control mr-2" placeholder="Phone Number">
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

            const clientType = document.getElementById('client_type_id');
            const industriesGroup = document.getElementById('industries-group');

            // Show on load
            const selectedOption = clientType.options[clientType.selectedIndex];
            if (selectedOption && selectedOption.dataset.name === 'Occupier') {
                industriesGroup.style.display = 'block';
            }

            clientType.addEventListener('change', function () {
                const option = this.options[this.selectedIndex];

                if (option && option.dataset.name === 'Occupier') {
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
