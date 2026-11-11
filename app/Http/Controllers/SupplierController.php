<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $supplierTypes = SupplierType::pluck('name', 'id')->toArray(); // [id => name]


        return view('pages.suppliers.index', compact('suppliers', 'supplierTypes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplierTypes = SupplierType::all();

        return view('pages.suppliers.form', compact('supplierTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage());

        DB::enableQueryLog();

        $supplier = new Supplier($request->all());

        $supplier['supplier_types'] = implode(',', $request->supplier_types);

        $supplier->created_by = auth()->id(); 

        $supplier->save();

          // Save contacts if provided
        foreach ($request->input('contacts', []) as $contact) {

            // Skip completely empty rows
            if (
                empty($contact['name']) &&
                empty($contact['phone']) &&
                empty($contact['email'])
            ) {
                continue;
            }

            $supplier->contacts()->create([
                'contact_name' => $contact['name'] ?? null,
                'phone' => $contact['phone'] ?? null,
                'email' => $contact['email'] ?? null,
            ]);
        }
        

        return redirect()->route('suppliers.index')
                     ->with('success', 'Supplier added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::with('contacts')->findOrFail($id);

        // Convert comma-separated string to array
        $selectedTypes = $supplier->supplier_types 
            ? explode(',', $supplier->supplier_types) 
            : [];
      
        $supplierTypes = SupplierType::all();

        return view('pages.suppliers.edit', compact('supplier', 'supplierTypes', 'selectedTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(self::formRule(), self::errorMessage());

        $supplier = Supplier::with('contacts')->findOrFail($id);

        // Update supplier details
        $supplier->fill($request->except('contacts', 'supplier_types'));

        $supplier->supplier_types = implode(',', $request->supplier_types ?? []);
        $supplier->updated_by = auth()->id();
    
        $supplier->save();

    /**
     * Update contacts
     * - Update existing contacts (with ID)
     * - Create new contacts
     * - Delete removed contacts
     */
    $existingContactIds = $supplier->contacts->pluck('id')->toArray();
    $submittedContactIds = [];
    
    foreach ($request->input('contacts', []) as $contact) {

        // Skip completely empty rows
        if (
            empty($contact['name']) &&
            empty($contact['phone']) &&
            empty($contact['email'])
        ) {
            continue;
        }

        if (!empty($contact['id'])) {

            // Only update contacts belonging to this supplier
            $existingContact = $supplier->contacts()
                ->where('id', $contact['id'])
                ->first();

            if ($existingContact) {
                $existingContact->update([
                    'contact_name' => $contact['name'] ?? null,
                    'phone' => $contact['phone'] ?? null,
                    'email' => $contact['email'] ?? null,
                ]);

                $submittedContactIds[] = $existingContact->id;
            }

        } else {

            // Create new contact
            $newContact = $supplier->contacts()->create([
                'contact_name' => $contact['name'] ?? null,
                'phone' => $contact['phone'] ?? null,
                'email' => $contact['email'] ?? null,
            ]);

            $submittedContactIds[] = $newContact->id;
        }
    }

    // Delete contacts removed from the form
    $contactsToDelete = array_diff($existingContactIds, $submittedContactIds);

    if (!empty($contactsToDelete)) {
        $supplier->contacts()
            ->whereIn('id', $contactsToDelete)
            ->delete();
    }

    return redirect()->route('suppliers.index')
        ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    public function formRule()
    {
        return [
            'business_name' => 'required',
            'business_address' => 'required',
            'unique_tax_reference' => 'required',
            'company_registration_number' => 'required',
            'vat_number' => 'required',
            'supplier_types' => 'required',
            'pli_cover_value' => 'required|numeric',
            'insurance_policy_expiry' => 'nullable|date',
            
        ];
    }

    public function errorMessage()
    {
        return [
            'business_name.required' => 'Business name is required.',
            'business_address.required' => 'Business address is required.',
            'unique_tax_reference.required' => 'Unique Tax Reference (UTR) is required.',
            'company_registration_number.required' => 'Company registration number is required.',
            'vat_number.required' => 'VAT number is required.',
            'supplier_types.required' => 'Please select at least one supplier type.',
            'pli_cover_value.required' => 'Public liability insurance cover value is required.',
            'pli_cover_value.numeric' => 'Public liability insurance cover value must be a number.',
            'insurance_policy_expiry.date' => 'Insurance policy expiry must be a valid date.',
        ];
    }
}
