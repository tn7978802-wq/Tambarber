<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bảng lưu danh sách "Sub-Owner" (được Root Owner thăng chức quản lý tối cao)
     * ngoài Root Owner định nghĩa cứng trong .env (SYSTEM_OWNER_EMAIL).
     */
    public function up(): void
    {
        Schema::create('sub_owners', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_owners');
    }
};