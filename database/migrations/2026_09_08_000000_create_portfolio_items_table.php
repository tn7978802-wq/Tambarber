<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Danh mục: fade, tao-kieu, cao-rau, tre-em, khac
            $table->string('category')->default('khac');

            // Ảnh chính (bắt buộc) + ảnh "trước khi cắt" (tuỳ chọn, để làm before/after)
            $table->string('image_after');
            $table->string('image_before')->nullable();

            $table->foreignId('barber_id')->nullable()
                ->constrained('barbers')->nullOnDelete();

            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['category', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
