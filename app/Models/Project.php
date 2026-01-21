<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'description',
        'reference',
        'project_type_id',
        'client_budget',
        'lead_owner',
        'pre_construction',
        'high_risk_building',
        'client_id',
        'size',
        'lead_source',
        'project_director',
        'designer',
        'referral_fee',
    ];

}
