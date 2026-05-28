<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostPlanItem extends Model
{
    use SoftDeletes;
    
    public function section(): BelongsTo{
        return $this->belongsTo(CostPlanSection::class);
    }

    public function supplier(): HasOne{
        return $this->hasOne(Supplier::class, "supplier_id");
    }
}
