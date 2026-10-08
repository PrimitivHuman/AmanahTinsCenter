<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Public & Admin: Get clinic settings
    public function show()
    {
        $setting = ClinicSetting::first();
        if (!$setting) {
            $setting = ClinicSetting::create([
                'clinic_name' => "Amanah Tin's Center",
                'phone' => '+62 717 9101234',
                'whatsapp' => '6282188899900',
                'email' => 'admin@amanahtinscenter.com',
                'address' => 'Jl. Jenderal Sudirman No. 88, Pangkalpinang, Bangka Belitung',
            ]);
        }

        return response()->json($setting);
    }

    // Admin: Update clinic settings
    public function update(Request $request)
    {
        $setting = ClinicSetting::first();
        if (!$setting) {
            $setting = new ClinicSetting();
        }

        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'maps_url' => 'nullable|string',
            'weekday_hours' => 'nullable|string|max:150',
            'weekend_hours' => 'nullable|string|max:150',
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'youtube' => 'nullable|string|max:100',
            'about_summary' => 'nullable|string',
        ]);

        $setting->fill($validated);
        $setting->save();

        return response()->json([
            'message' => 'Pengaturan klinik berhasil disimpan',
            'data' => $setting,
        ]);
    }
}
