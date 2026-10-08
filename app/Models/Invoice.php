<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'purchase_order_item_id',
        'invoice_number',
        'invoice_amount',
        'created_by',
    ];

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }

    public function created_user(): BelongsTo{
        return $this->belongsTo(User::class,"created_by");
    }

}
