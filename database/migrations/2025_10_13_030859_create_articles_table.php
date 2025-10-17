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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->default('');
            $table->text('note');
            $table->text('file_content_url');
            $table->text('thumbnail_url');
            $table->foreignId('writter_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('written_by');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->bigInteger('visited_times')->default(0);
            $table->timestamps();

            $table->fullText('title');
            $table->fullText('description');
            $table->fullText('written_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
