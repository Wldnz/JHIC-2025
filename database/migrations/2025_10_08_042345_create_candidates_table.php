<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidates', function (Blueprint $table) {
            $table->string('nisn', 10)->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('full_name', 255);
            $table->string('short_name', 100)->nullable();
            $table->date('birthdate');
            $table->string('birthplace', 255);
            $table->string('gender', 50);
            $table->string('citizenship', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('status_family', 100)->nullable();
            $table->integer('order_family')->nullable();
            $table->integer('sum_siblings')->nullable();
            $table->integer('sum_half_siblings')->nullable();
            $table->integer('sum_adopted_siblings')->nullable();
            $table->string('phone', 12);

            $table->foreignId('selected_phase_id')->nullable()->constrained('registration_phases')->nullOnDelete();
            $table->string('selected_phase_name', 255);
            $table->foreignId('registration_source_id')->nullable()->constrained('registration_sources')->nullOnDelete();
            $table->string('registration_source', 255);

            $table->string('origin_school', 255);
            $table->string('origin_school_address', 255);
            $table->text('enrolling_reason');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('candidates');
    }
};
