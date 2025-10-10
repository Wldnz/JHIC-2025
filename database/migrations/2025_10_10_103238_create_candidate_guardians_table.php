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
        Schema::create('candidate_guardians', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_nisn', 10);
            $table->enum('guardian_type', ['mother', 'father', 'other']);
            $table->string('full_name', 255);
            $table->string('birthplace', 255);
            $table->date('birthdate');
            $table->enum('citizenship', ['indonesia', 'other']);
            $table->enum('religion', ['islam', 'catholic', 'buddha', 'hindu', 'protestant', 'confucian', 'other']);
            $table->string('education', 150);
            $table->string('job', 150);
            $table->bigInteger('monthly_income');
            $table->text('home_address');
            $table->string('rt_rw', 10);
            $table->string('sub_district', 255);
            $table->string('district', 255);
            $table->string('city', 255);
            $table->string('postal_code', 11);
            $table->string('home_phone_number', 20)->nullable();
            $table->string('office_phone_number', 20)->nullable();
            $table->string('phone_number', 12);
            $table->timestamps();

            $table->foreign('candidate_nisn')->references('nisn')->on('candidates')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_guardians');
    }
};
