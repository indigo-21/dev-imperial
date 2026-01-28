<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'business_name',
        'business_address',
        'unique_tax_reference',
        'company_registration_number',
        'cis_rate',
        'vat_number',
        'client_type_id',
        'industry',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    
    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }
}
