<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $casts = [
        'insurance_policy_expiry' => 'datetime',
    ];

    protected $fillable = [
        'business_name',
        'business_address',
        'unique_tax_reference',
        'company_registration_number',
        'cis_rate',
        'vat_number',
        'supplier_types',
        'pli_cover_value',
        'insurance_policy_expiry',
        'created_by',
        'updated_by',
        'deleted_by',
    ];


    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }
}
