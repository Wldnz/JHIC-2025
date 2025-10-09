<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('article_medias', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->string('name', 255);
            $table->enum('type', ['image', 'video']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('article_medias');
    }
};