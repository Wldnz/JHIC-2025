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
        Schema::create("carts", function (Blueprint $table) {
            $table->id();
            $table->string("user_nis", 16)->nullable(false);
            $table->foreignId("product_variant_id")->constrained("product_variants")->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer("quantity")->default(1);
            $table->timestamps();

            $table->foreign("user_nis")->references("nis")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create("transactions", function (Blueprint $table) {
            $table->id();
            $table->string("user_nis", 16)->nullable(false);
            $table->string("received_email", 120)->nullable(false);
            $table->string("received_phone", 12)->nullable(false);
            $table->integer("total_product")->default(1);
            $table->double("total_price")->nullable(false);
            $table->string("payment_method", 70)->nullable(false);
            $table->timestamp("expired_at")->nullable(false);
            $table->timestamp("received_at")->nullable(false);
            $table->enum("status", ["pending", "success", "ongoing", "fail"])->default("pending");
            $table->text("note")->nullable(true);
            $table->timestamps();

            $table->foreign("user_nis")->references("nis")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create("order_transactions", function (Blueprint $table) {
            $table->id();
            $table->foreignId("transaction_id")->constrained("transactions")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("product_variant_id")->constrained("product_variants")->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists("carts");
        Schema::dropIfExists("order_transactions");
        Schema::dropIfExists("transactions");
    }
};
