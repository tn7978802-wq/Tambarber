<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('walkin_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barber_id')->constrained('barbers')->cascadeOnDelete();

            // 'walkin'  = khách đến trực tiếp cửa hàng
            // 'online'  = khách đặt lịch trên web, được đồng bộ sang khi admin bấm "Hoàn thành"
            $table->enum('source', ['walkin', 'online'])->default('walkin');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();

            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');

            $table->string('customer_name')->nullable();

            // Được ghi tự động bằng now() phía server, không cho nhập tay
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();

            $table->decimal('total_price', 12, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['status', 'started_at']);
            $table->index(['barber_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('walkin_sessions');
    }
};
