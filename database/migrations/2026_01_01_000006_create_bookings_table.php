<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('barber_id')->constrained('barbers');
            $table->date('booking_date');
            $table->string('booking_time'); // "14:00"
            $table->string('note')->nullable();
            $table->string('status')->default('pending'); // pending|confirmed|completed|cancelled
            $table->timestamps();

            $table->index(['barber_id', 'booking_date', 'booking_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};