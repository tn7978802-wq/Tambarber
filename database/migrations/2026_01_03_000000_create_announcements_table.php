<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng "Trạng thái / Sự kiện": các thông báo, khuyến mãi, sự kiện của tiệm
     * do quản trị viên đăng, có thể kèm ảnh, hiển thị ở khung bên phải Trang chủ.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamp('event_at')->nullable(); // thời gian diễn ra sự kiện (nếu có)
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
