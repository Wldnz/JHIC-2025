<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('registration_phases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('quota')->default(1);
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('registration_phases');
    }
};
