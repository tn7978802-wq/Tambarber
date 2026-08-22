<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('category')->nullable(); // fade, tao-kieu, cao-rau, tre-em
            $table->foreignId('hairstyle_id')->nullable()->constrained('hairstyles')->nullOnDelete();
            $table->foreignId('barber_id')->nullable()->constrained('barbers')->nullOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};