<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($supplier) ? 'Edit' : 'Create' }} Sub Contractor / Supplier
    </x-slot>

    <x-slot name="content">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST">
                    @csrf
                    @if(isset($supplier))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-6">
                            {{-- BUSINESS NAME --}}
                            <div class="form-group">
                                <label>Business Name</label>
                                <input type="text" name="business_name"
                                       class="form-control @error('business_name') is-invalid @enderror"
                                       value="{{ old('business_name', $supplier->business_name ?? '') }}"
                                       placeholder="Enter business name">
                                @error('business_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- BUSINESS ADDRESS --}}
                            <div class="form-group">
                                <label>Business Address</label>
                                <textarea name="business_address"
                                          class="form-control @error('business_address') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Enter business address">{{ old('business_address', $supplier->business_address ?? '') }}</textarea>
                                @error('business_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- UTR --}}
                            <div class="form-group">
                                <label>UTR (Unique Tax Reference)</label>
                                <input type="text" name="unique_tax_reference"
                                       class="form-control @error('unique_tax_reference') is-invalid @enderror"
                                       value="{{ old('unique_tax_reference', $supplier->unique_tax_reference ?? '') }}"
                                       placeholder="Enter UTR">
                                @error('unique_tax_reference')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- COMPANY REG --}}
                            <div class="form-group">
                                <label>Company Registration Number</label>
                                <input type="text" name="company_registration_number"
                                       class="form-control @error('company_registration_number') is-invalid @enderror"
                                       value="{{ old('company_registration_number', $supplier->company_registration_number ?? '') }}"
                                       placeholder="Enter registration number">
                                @error('company_registration_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- CIS Rates --}}
                            <div class="form-group">
                                <label>CIS Rates</label>
                                <select name="cis_rate" 
                                        class="form-control @error('cis_rate') is-invalid @enderror">
                                    @php
                                        $cisRates = ['0%', '20%', '30%'];
                                        $selectedRate = old('cis_rate', $supplier->cis_rate ?? '');
                                    @endphp

                                    @foreach($cisRates as $rate)
                                        <option value="{{ $rate }}" {{ $selectedRate == $rate ? 'selected' : '' }}>
                                            {{ $rate }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cis_rate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- VAT NUMBER --}}
                            <div class="form-group">
                                <label>VAT Number</label>
                                <input type="text" name="vat_number"
                                       class="form-control @error('vat_number') is-invalid @enderror"
                                       value="{{ old('vat_number', $supplier->vat_number ?? '') }}"
                                       placeholder="Enter VAT number">
                                @error('vat_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-6">
                            {{-- CONTACTS --}}
                            <div class="form-group">
                                <label>Contact Information</label>
                                <div id="contact-group">
                                    @php
                                        $contacts = old('contacts', $supplier->contacts ?? [['name'=>'','phone'=>'','email'=>'']]);
                                    @endphp
                                    @foreach ($contacts as $index => $contact)
                                        <div class="contact-info-group d-flex mb-2">
                                            <input type="text" name="contacts[{{ $index }}][name]" class="form-control mr-2" placeholder="Contact Name" value="{{ $contact['contact_name'] ?? '' }}">
                                            <input type="text" name="contacts[{{ $index }}][phone]" class="form-control mr-2" placeholder="Phone Number" value="{{ $contact['phone'] ?? '' }}">
                                            <input type="text" name="contacts[{{ $index }}][email]" class="form-control mr-2" placeholder="Email Address" value="{{ $contact['email'] ?? '' }}">
                                            <div class="contact-info-group-append">
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

                            {{-- SUPPLIER TYPE --}}
                            <div class="form-group">
                                <label>Supplier Type</label>
                                <div class="dropdown @error('supplier_types') border border-danger @enderror">
                                    @php
                                        // Get names of selected supplier types
                                        $selectedNames = isset($selectedTypes) 
                                            ? $supplierTypes->whereIn('id', $selectedTypes)->pluck('name')->toArray()
                                            : [];
                                    @endphp
                                    <button class="btn btn-outline-secondary dropdown-toggle w-100 text-left"
                                            type="button" id="supplierDropdown" data-toggle="dropdown">
                                        {{ count($selectedNames) ? implode(', ', $selectedNames) : 'Select Supplier Type(s)' }}
                                    </button>
                                    <div class="dropdown-menu w-100 p-2">
                                        <div class="form-group mb-2">
                                            <input type="text" id="supplierSearch" class="form-control" placeholder="Search supplier type...">
                                        </div>

                                        <div id="supplierList">
                                            @php
                                                // Convert comma-separated string to array for pre-checking
                                                $selectedTypes = isset($supplier) && $supplier->supplier_types
                                                    ? explode(',', $supplier->supplier_types)
                                                    : [];
                                            @endphp
                                            @foreach ($supplierTypes as $supplierType)
                                                <div class="form-check">
                                                    <input class="form-check-input supplier-checkbox"
                                                        value="{{ $supplierType->id }}"
                                                        data-name="{{ $supplierType->name }}"
                                                        type="checkbox"
                                                        name="supplier_types[]"
                                                        id="type_{{ $loop->index }}"
                                                                      @if(in_array($supplierType->id, $selectedTypes ?? [])) checked @endif>
                                                    <label class="form-check-label" for="type_{{ $loop->index }}">
                                                        {{ $supplierType->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                @error('supplier_types')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                         {{-- PLI COVER --}}
                        <div class="form-group mt-4">
                            <label>Public Liability Insurance Cover Value</label>
                            <select name="pli_cover_value"
                                    class="form-control @error('pli_cover_value') is-invalid @enderror">
                                @php
                                    $options = [1, 2, 5, 10, 20];
                                    $selected = old('pli_cover_value', $supplier->pli_cover_value ?? '');
                                @endphp

                                <option value="" disabled {{ $selected === '' ? 'selected' : '' }}>Select value</option>

                                @foreach ($options as $option)
                                    <option value="{{ $option }}" {{ (string)$selected === (string)$option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>

                            @error('pli_cover_value')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                            {{-- EXPIRY DATE --}}
                            <div class="form-group">
                                <label>Insurance Policy Expiry</label>
                                <input type="date" name="insurance_policy_expiry"
                                       class="form-control @error('insurance_policy_expiry') is-invalid @enderror"
                                       value="{{ old('insurance_policy_expiry', isset($supplier) && $supplier->insurance_policy_expiry ? $supplier->insurance_policy_expiry->format('Y-m-d') : '') }}">
                                @error('insurance_policy_expiry')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-6">
                            <h4>Bank Details</h4>
                            {{-- BANK ACCOUNT NAME --}}
                            <div class="form-group">
                                <label>Bank Account Name</label>
                                <input type="text" name="bank_account_name"
                                       class="form-control @error('bank_account_name') is-invalid @enderror"
                                       value="{{ old('bank_account_name', $supplier->bank_account_name ?? '') }}"
                                       placeholder="Enter bank account name">
                                @error('bank_account_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- BANK ACCOUNT NUMBER --}}
                            <div class="form-group">
                                <label>Bank Account Number</label>
                                <input type="text" name="bank_account_number"
                                       class="form-control @error('bank_account_number') is-invalid @enderror"
                                       value="{{ old('bank_account_number', $supplier->bank_account_number ?? '') }}"
                                       placeholder="Enter bank account number">
                                @error('bank_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                             {{-- SORT CODE --}}
                             <div class="form-group">
                                <label>Sort Code</label>
                                <input type="text" name="sort_code"
                                       class="form-control @error('sort_code') is-invalid @enderror"
                                       value="{{ old('sort_code', $supplier->sort_code ?? '') }}"
                                       placeholder="Enter sort code">
                                @error('sort_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($supplier) ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    @section('scripts')
    <script>
        let contactIndex = {{ count($contacts ?? [1]) }};

        function addContact() {
            const group = document.createElement('div');
            group.classList.add('contact-info-group', 'mb-2', 'd-flex');
            group.innerHTML = `
                <input type="text" name="contacts[${contactIndex}][name]" class="form-control mr-2" placeholder="Contact Name" required>
                <input type="text" name="contacts[${contactIndex}][phone]" class="form-control mr-2" placeholder="Phone Number">
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
                selected.push($(this).data('name'));
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
