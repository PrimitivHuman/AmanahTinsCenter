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
        'specialization',
        'bio',
        'experience_years',
        'certifications',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'certifications' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
