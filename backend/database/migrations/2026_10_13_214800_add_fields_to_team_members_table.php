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
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('edu')->nullable()->after('role');
            $table->string('schedule')->nullable()->after('experience_years');
            $table->string('str_number')->nullable()->after('schedule');
            $table->text('philosophy')->nullable()->after('bio');
            $table->json('tags')->nullable()->after('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['edu', 'schedule', 'str_number', 'philosophy', 'tags']);
        });
    }
};
