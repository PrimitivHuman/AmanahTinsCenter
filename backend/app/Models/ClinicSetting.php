<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_name',
        'tagline',
        'phone',
        'whatsapp',
        'email',
        'address',
        'maps_url',
        'weekday_hours',
        'weekend_hours',
        'instagram',
        'facebook',
        'youtube',
        'about_summary',
    ];
}
