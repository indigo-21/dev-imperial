<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    public function purchase_order() {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
