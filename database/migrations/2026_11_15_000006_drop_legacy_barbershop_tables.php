<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'walkin_session_service',
            'walkin_sessions',
            'portfolio_items',
            'comments',
            'bookings',
            'portfolios',
            'announcements',
            'reviews',
            'contact_messages',
            'posts',
            'hairstyles',
            'services',
            'barbers',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }

    public function down(): void
    {
        throw new RuntimeException('Barbershop tables and data cannot be restored by rolling this migration back.');
    }
};
