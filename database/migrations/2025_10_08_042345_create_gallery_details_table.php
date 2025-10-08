<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gallery_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->cascadeOnDelete();
            $table->string('name', 255);
            $table->text('image_url');
            $table->boolean('is_thumbnail')->default(false);
        });
    }

    public function down(): void {
        Schema::dropIfExists('gallery_details');
    }
};