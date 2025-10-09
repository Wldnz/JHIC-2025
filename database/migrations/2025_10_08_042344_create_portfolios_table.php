<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id');
            $table->string('student_name', 255);
            $table->enum('student_class', ['X', 'XI', 'XII']);
            $table->foreignId('student_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->string('student_major_name', 120);
            $table->string('title', 255);
            $table->text('description');
            $table->text('supporting_link');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('portfolios');
    }
};