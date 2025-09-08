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
        Schema::create("products", function (Blueprint $table) {
            $table->string("id",16)->primary()->nullable(false);
            $table->string("name",255)->nullable(false);
            $table->enum("category", ["uniform", "attribute"])->default("uniform");
            $table->timestamps();
            $table->boolean("visible")->default(true);
        });

        Schema::create("product_variants", function(Blueprint $table) {
            $table->id();
            $table->string("product_id", 16)->nullable(false);
            $table->string("name",60)->nullable(false);
            $table->string("type",60)->comment("S/M/L/XL or Jumbo")->nullable(false);
            $table->double("price")->nullable(false);
            $table->integer("stock")->default(0)->nullable(false);
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");
        });

        Schema::create("product_image", function (Blueprint $table) {
            $table->id();
            $table->string("product_id", 16)->nullable(false);
            $table->string("url")->nullable(false);
            $table->timestamps();
            $table->boolean("visible")->default(true);
            
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("product_image");     
        Schema::dropIfExists("product_variants");     
        Schema::dropIfExists("products");     
    }
};
