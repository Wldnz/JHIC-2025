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
        Schema::create('candidate_phases', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_nisn', 10);
            $table->foreignId('selected_phase_id')->nullable()->constrained('registration_phases')->nullOnDelete();
            $table->string('selected_phase_name', 255)->nullable();
            $table->foreignId('registration_source_id')->nullable()->constrained('registration_sources')->nullOnDelete();
            $table->string('registration_source', 255);
            $table->text('enrolling_reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_phases');
    }
};
