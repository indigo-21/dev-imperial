<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($client) ? 'Edit' : 'Create' }} Client
    </x-slot>

    <x-slot name="content">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" method="POST">
                    @csrf
                    @if(isset($client))
                        @method('PUT')
                    @endif

                    <div class="row">
                        {{-- LEFT COLUMN --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Business Name</label>
                                <input type="text" name="business_name"
                                       class="form-control @error('business_name') is-invalid @enderror"
                                       value="{{ old('business_name', $client->business_name ?? '') }}"
                                       placeholder="Enter business name">
                                @error('business_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Business Address</label>
                                <textarea name="business_address"
                                          class="form-control @error('business_address') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Enter business address">{{ old('business_address', $client->business_address ?? '') }}</textarea>
                                @error('business_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Contacts --}}
                            <div class="form-group">
                                <label>Contact Information</label>
                                <div id="contact-group">
                                    @php
                                        $contacts = old('contacts', $client->contacts ?? [['name'=>'','phone'=>'','email'=>'']]);
                                    @endphp

                                    @foreach ($contacts as $index => $contact)
                                        <div class="contact-info-group d-flex mb-2">
                                            <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact['id'] ?? '' }}">
                                            <input type="text" name="contacts[{{ $index }}][name]" class="form-control mr-2" placeholder="Contact Name" value="{{ $contact['name'] ?? $contact['contact_name'] ?? '' }}" required>
                                            <input type="text" name="contacts[{{ $index }}][phone]" class="form-control mr-2" placeholder="Phone Number" value="{{ $contact['phone'] ?? '' }}">
                                            <input type="email" name="contacts[{{ $index }}][email]" class="form-control mr-2" placeholder="Email Address" value="{{ $contact['email'] ?? '' }}">
                                            <div>
                                                @if($index === 0)
                                                    <button type="button" class="btn btn-success" onclick="addContact()"><i class="fa fa-plus"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-danger" onclick="removeContact(this)"><i class="fa fa-minus"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>UTR (Unique Tax Reference)</label>
                                <input type="text" name="unique_tax_reference" class="form-control" value="{{ old('unique_tax_reference', $client->unique_tax_reference ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Company Registration Number</label>
                                <input type="text" name="company_registration_number" class="form-control" value="{{ old('company_registration_number', $client->company_registration_number ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>VAT Number</label>
                                <input type="text" name="vat_number" class="form-control" value="{{ old('vat_number', $client->vat_number ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label>Client Type</label>
                                <select name="client_type_id" id="client_type_id" class="form-control">
                                    <option value="">-- Select Client Type --</option>
                                    @foreach ($clientTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('client_type_id', $client->client_type_id ?? '') == $type->id ? 'selected' : '' }} data-name="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="industries-group" style="display: {{ optional($client->clientType)->name === 'Occupier' ? 'block' : 'none' }}">
                                <label>Industry</label>
                                <select name="industry" id="industry" class="form-control select2">
                                    <option value="">-- Select Industry --</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry }}" {{ old('industry', $client->industry ?? '') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ isset($client) ? 'Update' : 'Create' }} Client</button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        <script>
            let contactIndex = {{ count($contacts) }};
            
            function addContact() {
                const wrapper = document.getElementById('contact-group');
                const row = document.createElement('div');
                row.classList.add('contact-info-group', 'd-flex', 'mb-2');
                row.innerHTML = `
                    <input type="text" name="contacts[${contactIndex}][name]" class="form-control mr-2" placeholder="Contact Name" required>
                    <input type="text" name="contacts[${contactIndex}][phone]" class="form-control mr-2" placeholder="Phone Number">
                    <input type="email" name="contacts[${contactIndex}][email]" class="form-control mr-2" placeholder="Email Address">
                    <button type="button" class="btn btn-danger" onclick="removeContact(this)"><i class="fa fa-minus"></i></button>
                `;
                wrapper.appendChild(row);
                contactIndex++;
            }

            function removeContact(el) {
                el.closest('.contact-info-group').remove();
            }

            // Show industries if client type is Occupier
            document.getElementById('client_type_id').addEventListener('change', function() {
                const selected = this.options[this.selectedIndex].dataset.name;
                document.getElementById('industries-group').style.display = selected === 'Occupier' ? 'block' : 'none';
                if(selected !== 'Occupier') document.getElementById('industry').value = '';
            });
        </script>
    @endsection
</x-app-layout>
