<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'child_name',
        'child_age',
        'phone',
        'email',
        'service_type',
        'preferred_date',
        'preferred_time',
        'notes',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];
}
