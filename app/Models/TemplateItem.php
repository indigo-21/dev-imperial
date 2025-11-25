<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
    protected $fillable = [
        'template_section_id',
        'item_code',
        'description',
        'quantity',
        'unit',
        'rate',
        'mark_up',
    ];

    public function section()
    {
        return $this->belongsTo(TemplateSection::class);
    }
}
