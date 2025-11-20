<x-app-layout>
    <x-slot name="pageTitle">
        {{ isset($supplierType) ? 'Edit Supplier Type' : 'Create Supplier Type' }}
    </x-slot>

    <x-slot name="content">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="{{ isset($supplierType) ? route('supplier-types.update', $supplierType->id) : route('supplier-types.store') }}" method="POST">
                    @csrf
                    @if (isset($supplierType))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label>Supplier Type Name <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control" 
                            placeholder="Enter supplier type name"
                            value="{{ old('name', $supplierType->name ?? '') }}"
                            required
                        >
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('supplier-types.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($supplierType) ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>
