<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'edu',
        'specialization',
        'tags',
        'bio',
        'philosophy',
        'experience_years',
        'schedule',
        'str_number',
        'certifications',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'certifications' => 'array',
        'tags' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
