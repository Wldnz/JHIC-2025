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
        Schema::create('midtrans_transactions', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->foreignId('self_order_id')->unique();
            $table->string('status_code');
            $table->text('status_message');
            $table->text('transaction_time');
            $table->string('transaction_status');
            $table->string('fraud_status');
            $table->string('approval_code');
            $table->text('gross_amount');
            $table->string('payment_type');
            $table->string('card_type');
            $table->string('payment_option_type');
            $table->text('reference_id');
            $table->timestamps();

            $table->foreign('self_order_id')->references('id')->on('transactions')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midtrans_transactions');
    }
};
