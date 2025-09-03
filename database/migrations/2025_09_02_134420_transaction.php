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
        Schema::create("cart", function(Blueprint $table) {
            $table->id();
            $table->string("user_nis", 16)->nullable(false);
            $table->foreignId("variant_product_id")->constrained("variant_product")->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer("quantity")->default(1);
            $table->timestamps();
            
            $table->foreign("user_nis")->references("nis")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create("transaction", function(Blueprint $table) {
            $table->id();
            $table->string("user_nis", 16)->nullable(false);
            $table->string("received_email",120)->nullable(false);
            $table->string("received_phone", 12)->nullable(false);
            $table->integer("total_product")->default(1);
            $table->double("total_price")->nullable(false);
            $table->timestamps();
            $table->timestamp("expired")->nullable(false);
            $table->enum("status", ["pending", "success", "ongoing", "fail"])->default("pending");
            
            $table->foreign("user_nis")->references("nis")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create("order", function(Blueprint $table) {
            $table->id();
            $table->foreignId("transaction_id")->constrained("transaction")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("variant_product_id")->constrained("variant_product")->cascadeOnDelete()->cascadeOnUpdate();
            $table->double("price")->nullable(false);
            $table->integer("quantity")->nullable(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("cart");
        Schema::dropIfExists("order");
        Schema::dropIfExists("transaction");
    }
};
