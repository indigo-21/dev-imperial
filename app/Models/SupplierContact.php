<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
   protected $fillable = [
        'supplier_id', 'contact_name', 'email', 'phone'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


}
