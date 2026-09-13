<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('walkin_session_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('walkin_session_id')->constrained('walkin_sessions')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();

            // Lưu lại giá tại thời điểm thực hiện, để không bị ảnh hưởng
            // nếu sau này giá dịch vụ gốc thay đổi.
            $table->decimal('price', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('walkin_session_service');
    }
};
