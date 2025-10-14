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
        Schema::create('candidate_documents', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_nisn', 10);
            $table->string('name', 255);
            $table->text('file_url');
            $table->boolean('is_valid')->default(false);
            $table->timestamps();

            $table->foreign('candidate_nisn')->references('nisn')->on('candidates')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_documents');
    }
};
