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
        Schema::create('candidate_usm_results', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_nisn', 10);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('registration_phase_id')->nullable()->constrained('registration_phases')->nullOnDelete();
            $table->foreignId('selected_major_id')->nullable()->constrained('majors')->nullOnDelete();

            $table->string('candidate_full_name');
            $table->string('candidate_origin_school');
            $table->string('registration_phase_name');
            $table->string('selected_major_long_name');

            $table->decimal('min_value', 3, 1)->unsigned()->default(75);
            $table->decimal('average_value', 3, 1)->unsigned();
            $table->boolean('is_passed');

            $table->date('signed_at');
            $table->string('signed_by');
            $table->date('certificate_collection_from_at');
            $table->date('certificate_collection_to_at');

            $table->timestamps();

            $table->foreign('candidate_nisn')->references('nisn')->on('candidates')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_usm_results');
    }
};
