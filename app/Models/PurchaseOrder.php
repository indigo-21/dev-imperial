<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PurchaseOrder extends Model
{
    use SoftDeletes;

    public function supplier(): BelongsTo{
        return $this->belongsTo(Supplier::class, "supplier_id");
    }

    public function project(): BelongsTo{
        return $this->belongsTo(Project::class, "project_id");
    }

    public function created_user(): BelongsTo{
        return $this->belongsTo(User::class,"created_by");
    }

    public function po_items(): HasMany{
        return $this->hasMany(PurchaseOrderItem::class, "purchase_order_id");
    }

}
