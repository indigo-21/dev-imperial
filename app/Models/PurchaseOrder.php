<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PurchaseOrder extends Model
{
    use SoftDeletes;

    public function supplier(){
        return $this->belongsTo(Supplier::class, "supplier_id");
    }

    public function created_user(){
        return $this->belongsTo(User::class,"created_by");
    }


}
