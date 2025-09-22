<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string("nis", 16)->primary();
            $table->string('no_telp', 12);
            $table->enum('gender', ['male', 'female']);
            $table->text('address');
            $table->timestamp('birthdate');
            $table->enum('class', ['X', 'XI', 'XII']);
            $table->foreignId('major_id')->nullable();
            $table->string('major_name', 50);

            $table->foreign('nis')->references('nis')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('major_id')->references('id')->on('majors')->nullOnDelete()->nullOnUpdate();
        });

        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('majors');
    }
};
