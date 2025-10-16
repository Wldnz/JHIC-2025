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
        Schema::create('major_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->text('image_url');
            $table->string('name');
            $table->string('message');
            $table->string('major_long_name', 120);
            $table->string('major_short_name', 50);
            $table->string('current_company')->nullable();
            $table->string('current_company_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('major_alumni');
    }
};
