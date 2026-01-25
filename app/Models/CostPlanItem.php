<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CostPlanItem extends Model
{
    public function supplier(): HasOne{
        return $this->hasOne(Supplier::class, "supplier_id");
    }
}
