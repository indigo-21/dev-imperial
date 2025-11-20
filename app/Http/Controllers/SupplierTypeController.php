<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierType;
use Illuminate\Http\Request;

class SupplierTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplierTypes = SupplierType::all();

        return view('pages.configurations.supplier_types.index')->with('supplierTypes', $supplierTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.configurations.supplier_types.form');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::enableQueryLog();

        $request->validate([
            'name' => 'required|unique:supplier_types,name',
        ]);

        SupplierType::create([
            'name' => $request->name,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('supplier-types.index')
                     ->with('success', 'Supplier type added successfully!');
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
    public function edit(SupplierType $supplierType)
    {
        // $supplierTypes = SupplierType::all();

        return view('pages.configurations.supplier_types.form', compact('supplierType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
