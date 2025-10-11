<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('student_nis')->nullable();
            $table->string('student_name', 255);
            $table->enum('student_class', ['X', 'XI', 'XII']);
            $table->foreignId('student_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->string('student_major_name', 120);
            $table->enum('competition_position', ['grade_1', 'grade_2', 'grade_3'])->default('grade_3');
            $table->string('competition_name', 255);
            $table->enum('competition_level', ['school', 'subdistrict', 'district', 'provincial', 'national', 'international'])->default('school');
            $table->timestamp('won_at');
            $table->text('thumbnail_url');
            $table->timestamps();

            $table->foreign('student_nis')->references('nis')->on('students')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('achievements');
    }
};
