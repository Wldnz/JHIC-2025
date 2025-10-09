<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->string('nis', 17)->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 255);
            $table->enum('class', ['X', 'XI', 'XII']);
            $table->foreignId('major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->string('major_name', 255);
            $table->enum('gender', ['male', 'female']);
            $table->date('birthdate');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
