<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($supplier) ? 'Edit' : 'Create' }} Sub Contractor / Supplier
    </x-slot>

    <x-slot name="content">
        <div class="card card-primary card-outline">
            <div class="card-body">
                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="supplierFormTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab">
                            Supplier Details
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab">
                            Supplier Documents
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-3" id="supplierFormTabsContent">
                    {{-- Supplier Details Tab --}}
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <form action="{{ isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store') }}" method="POST">
                            @csrf
                            @if(isset($supplier))
                                @method('PUT')
                            @endif

                            {{-- Existing form fields here... --}}
                            <div class="row">
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

                        <div class="col-md-6">
                            {{-- CONTACTS --}}
                            <div class="form-group">
                                <label>Contact Information</label>

                                <div id="contact-group">
                                    @php
                                        $contacts = old(
                                            'contacts',
                                            isset($supplier)
                                                ? $supplier->contacts->toArray()
                                                : [['contact_name' => '', 'phone' => '', 'email' => '']]
                                        );
                                    @endphp

                                    @foreach ($contacts as $index => $contact)
                                        <div class="contact-info-group d-flex mb-2">

                                            {{-- IMPORTANT: Contact ID --}}
                                            @if(!empty($contact['id']))
                                                <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact['id'] }}">
                                            @endif

                                            <input
                                                type="text"
                                                name="contacts[{{ $index }}][name]"
                                                class="form-control mr-2"
                                                placeholder="Contact Name"
                                                value="{{ $contact['contact_name'] ?? $contact['name'] ?? '' }}"
                                            >

                                            <input
                                                type="text"
                                                name="contacts[{{ $index }}][phone]"
                                                class="form-control mr-2"
                                                placeholder="Phone Number"
                                                value="{{ $contact['phone'] ?? '' }}"
                                            >

                                            <input
                                                type="email"
                                                name="contacts[{{ $index }}][email]"
                                                class="form-control mr-2"
                                                placeholder="Email Address"
                                                value="{{ $contact['email'] ?? '' }}"
                                            >

                                            <div class="contact-info-group-append">
                                                @if ($index === 0)
                                                    <button type="button" class="btn btn-success" onclick="addContact()">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger" onclick="removeContact(this)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
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

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($supplier) ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Supplier Documents Tab --}}
                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                         {{-- Upload Form --}}
                            <div class="col-md-12">
                            
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    @csrf

                                        <div class="col-md-6">
                                        {{-- File Description --}}
                                        <div class="form-group">
                                            <label for="description">File Description</label>
                                            <input type="text" name="description" id="description" class="form-control"
                                                placeholder="Enter a brief description">
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                            {{-- File Upload --}}
                                        <div class="form-group">
                                            <label for="document">Select Document</label>
                                            <input type="file" name="document" id="document" class="form-control-file">
                                        </div>
                                            {{-- Buttons --}}
                                        <div class="form-group mt-3">
                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                            <button type="submit" class="btn btn-primary ml-2">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        <div class="col-md-12">
                            <h5 class="mb-3 text-center"><strong>Uploaded Documents</strong></h5>
                            <table id="documentsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="25%">Description</th>
                                        <th width="25%">File Name</th>
                                        <th width="20%">Uploaded By</th>
                                        <th width="15%">Date</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Example / demo data --}}
                                    <tr>
                                        <td>1</td>
                                        <td>Site Layout Plan</td>
                                        <td><a href="#">layout_plan.pdf</a></td>
                                        <td>Sarah Thompson</td>
                                        <td>2025-10-20</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-slot>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#documentsTable').DataTable(); // Initialize datatable for documents
            });
        </script>
        {{-- Include your existing contact add/remove JS --}}
    @endsection
</x-app-layout>
