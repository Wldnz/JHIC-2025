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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_nisn', 10)->nullable();
            $table->string('candidate_full_name', 255);
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();
            $table->string('payment_method_display_name', 100);
            $table->integer('total_cost');
            $table->timestamp('expired_at');
            $table->enum('status', [
                'authorize',
                'capture',
                'settlement',
                'deny',
                'pending',
                'cancel',
                'refund',
                'partial_refund',
                'partial_chargeback',
                'expire',
                'failure',
            ]);
            $table->timestamps();

            $table->foreign('candidate_nisn')->references('nisn')->on('candidates')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
