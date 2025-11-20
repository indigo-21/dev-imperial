<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSection extends Model
{
    protected $fillable = [
        'section_code',
        'section_name',
    ];

    public function items()
    {
        return $this->hasMany(TemplateItem::class);
    }
}



