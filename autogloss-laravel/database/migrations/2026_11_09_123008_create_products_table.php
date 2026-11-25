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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('sub_category')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('original_price', 12, 2)->nullable();
            $table->boolean('is_promo')->default(false);
            $table->integer('discount_percent')->default(0);
            $table->integer('stock')->default(0);
            $table->string('unit')->default('1 Liter');
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->integer('sold_count')->default(0);
            $table->text('image')->nullable();
            $table->string('badge')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
