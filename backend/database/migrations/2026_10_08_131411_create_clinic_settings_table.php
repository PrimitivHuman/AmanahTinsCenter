<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_name')->default("Amanah Tin's Center");
            $table->string('tagline')->default('Tumbuh Bersama, Berkembang dengan Percaya Diri');
            $table->string('phone')->default('+62 821-2345-6789');
            $table->string('whatsapp')->default('6282123456789');
            $table->string('email')->default('info@amanahtinscenter.com');
            $table->text('address')->nullable();
            $table->text('maps_url')->nullable();
            $table->string('weekday_hours')->default('Senin - Jumat: 08:00 - 17:00');
            $table->string('weekend_hours')->default('Sabtu: 08:00 - 15:00, Minggu: Tutup');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->text('about_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_settings');
    }
};
