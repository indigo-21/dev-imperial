<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        $clientTypes = ClientType::pluck('name', 'id')->toArray(); // [id => name]

        return view('pages.clients.index', compact('clients', 'clientTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientTypes = ClientType::all();

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

        return view('pages.clients.form', compact('clientTypes', 'industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage());

        DB::enableQueryLog();

        $client = new Client($request->all());
        $client->created_by = auth()->id();
        $client->save();

        // Save contacts if provided
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contact) {
                if (empty($contact['name']) && empty($contact['phone']) && empty($contact['email'])) {
                    continue;
                }

                $client->contacts()->create([
                    'client_id' => $client->id,
                    'contact_name' => $contact['name'],
                    'phone' => $contact['phone'] ?: null,
                    'email' => $contact['email'] ?: null, 
                ]);
            }
        }

        return redirect()->route('clients.index')
                         ->with('success', 'Client added successfully!');
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
        $client = Client::with('contacts')->findOrFail($id);
        $clientTypes = ClientType::all();

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

        return view('pages.clients.edit', compact('client', 'clientTypes', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(self::formRule(), self::errorMessage());

        $client = Client::with('contacts')->findOrFail($id);

        $client->fill($request->all());
        $client->updated_by = auth()->id();
        $client->save();

        /**
         * Update contacts
         */
        $existingContactIds = $client->contacts->pluck('id')->toArray();
        $submittedContactIds = [];

        if ($request->has('contacts')) {
            foreach ($request->contacts as $contact) {
                // Skip empty
                if (
                    empty($contact['name']) &&
                    empty($contact['phone']) &&
                    empty($contact['email'])
                ) {
                    continue;
                }

                if (!empty($contact['id'])) {
                    $submittedContactIds[] = $contact['id'];

                    $client->contacts()
                        ->where('id', $contact['id'])
                        ->update([
                            'contact_name' => $contact['name'] ?? null,
                            'phone' => $contact['phone'] ?? null,
                            'email' => $contact['email'] ?? null,
                        ]);
                } else {
                    $newContact = $client->contacts()->create([
                        'contact_name' => $contact['name'] ?? null,
                        'phone' => $contact['phone'] ?? null,
                        'email' => $contact['email'] ?? null,
                    ]);
                    $submittedContactIds[] = $newContact->id;
                }
            }
        }

        // Delete removed contacts
        $contactsToDelete = array_diff($existingContactIds, $submittedContactIds);
        if (!empty($contactsToDelete)) {
            $client->contacts()->whereIn('id', $contactsToDelete)->delete();
        }

        return redirect()->route('clients.index')
                         ->with('success', 'Client updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')
                         ->with('success', 'Client deleted successfully!');
    }

    public function formRule()
    {
        return [
            'business_name' => 'required',
            'business_address' => 'nullable',
            'unique_tax_reference' => 'nullable',
            'company_registration_number' => 'nullable',
            'vat_number' => 'nullable',
            'client_type_id' => 'nullable|exists:client_types,id',
            'industry' => 'nullable',
        ];
        
    }

    public function errorMessage()
    {
        return [
            'business_name.required' => 'Business name is required.',
        ];
    }

    

}
