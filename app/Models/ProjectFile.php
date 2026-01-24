<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFile extends Model
{
    use SoftDeletes;

    public function created_user(): BelongsTo{
        return $this->belongsTo(User::class, "created_by");
    }
    public function updated_user(): BelongsTo{
        return $this->belongsTo(User::class, "updated_by");
    }
}
