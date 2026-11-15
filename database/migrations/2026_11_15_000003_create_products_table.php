<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('brand')->nullable();
            $table->string('unit', 50)->default('Cái');
            $table->decimal('stock_quantity', 14, 3)->default(0);
            $table->decimal('min_stock_alert', 14, 3)->default(0);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
