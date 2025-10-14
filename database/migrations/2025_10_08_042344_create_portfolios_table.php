<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function PHPUnit\Framework\isEmpty;

return new class extends Migration {
    public function up(): void {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('student_nis', 17)->nullable();
            $table->string('student_name', 255);
            $table->enum('student_class', ['X', 'XI', 'XII']);
            $table->foreignId('student_major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->string('student_major_name', 120);
            $table->string('title', 255);
            $table->text('description');
            $table->enum('link_type', ['youtube', 'instagram', 'tiktok', 'website', 'other']);
            $table->text('supporting_link');
            $table->timestamps();

            $table->foreign('student_nis')->references('nis')->on('students')->nullOnDelete();

            $table->fullText(['student_name']);
            $table->index(['student_class']);
            $table->fullText(['student_major_name']);
            $table->fullText(['title']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('portfolios');
    }
};
