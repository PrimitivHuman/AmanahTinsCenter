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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('child_name');
            $table->string('child_age')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('service_type'); // Terapi Wicara, Terapi Okupasi, Sensori Integrasi, Fisioterapi Anak, Skrining
            $table->date('preferred_date');
            $table->string('preferred_time')->nullable(); // Pagi (09:00 - 12:00), Siang (13:00 - 17:00)
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
