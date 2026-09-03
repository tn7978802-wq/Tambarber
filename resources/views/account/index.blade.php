@extends('layouts.app')

@section('title', 'Tài khoản của tôi - Tâm Barbershop')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <!-- USER INFO HEADER CARD -->
    <div class="mb-10 rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 shadow-2xl relative overflow-hidden" 
         style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        
        <!-- Background Pattern Decor -->
        <div class="absolute -right-10 -bottom-10 text-[#3c2c15]/20 text-9xl pointer-events-none select-none">
            <i class="fa-solid fa-id-card"></i>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
            <div class="flex items-center gap-4">
                <!-- User Avatar Badge -->
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border-2 border-[#8a641d] bg-[#0b0805] text-[#f2d788] shadow-md">
                    <i class="fa-solid fa-user text-2xl"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Tài khoản khách hàng</span>
                    <h1 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788] leading-tight">
                        {{ auth()->user()->fullname }}
                    </h1>
                    <p class="text-xs text-[#f4ecd8]/80 flex items-center gap-2 mt-0.5">
                        <i class="fa-regular fa-envelope text-[#8a641d]"></i> {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('booking.create') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110 active:scale-[0.99] shadow-md">
                <i class="fa-solid fa-calendar-plus"></i>
                <span>Đặt lịch hẹn mới</span>
            </a>
        </div>
    </div>

    <!-- BOOKING HISTORY SECTION -->
    <div class="space-y-4">
        
        <!-- Section Header -->
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Quản lý cuộc hẹn</span>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788]">Lịch sử đặt lịch</h2>
            </div>
            <span class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3 py-1 text-xs text-[#6f6248]">
                Tổng cộng: <strong class="text-[#f2d788]">{{ $bookings->count() }}</strong>
            </span>
        </div>

        <!-- Barber Pole Stripe Divider -->
        <div class="h-[2px] w-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        <!-- Bookings Table -->
        <div class="overflow-x-auto rounded-[2px] border border-[#3c2c15] bg-[#171008] shadow-xl">
            <table class="w-full text-left text-xs text-[#f4ecd8]">
                <!-- Table Head -->
                <thead class="border-b border-[#3c2c15] bg-[#251b0e] font-['Bebas_Neue'] text-sm tracking-wider text-[#f2d788] uppercase">
                    <tr>
                        <th class="px-4 py-3.5">Mã lịch hẹn</th>
                        <th class="px-4 py-3.5">Dịch vụ</th>
                        <th class="px-4 py-3.5">Barber</th>
                        <th class="px-4 py-3.5">Thời gian</th>
                        <th class="px-4 py-3.5 text-right">Trạng thái</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-[#3c2c15]">
                    @forelse ($bookings as $booking)
                        <tr class="transition-colors hover:bg-[#251b0e]/60">
                            <!-- Code -->
                            <td class="px-4 py-3.5 font-mono font-bold text-[#f2d788]">
                                #{{ $booking->booking_code }}
                            </td>

                            <!-- Service -->
                            <td class="px-4 py-3.5 font-medium text-[#f4ecd8]">
                                {{ $booking->service->name ?? 'N/A' }}
                            </td>

                            <!-- Barber -->
                            <td class="px-4 py-3.5 text-[#f4ecd8]/90">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-scissors text-[10px] text-[#8a641d]"></i>
                                    {{ $booking->barber->name ?? 'Mặc định' }}
                                </span>
                            </td>

                            <!-- Time & Date -->
                            <td class="px-4 py-3.5 text-[#f4ecd8]/80">
                                <span class="block font-semibold text-[#f4ecd8]">
                                    <i class="fa-regular fa-clock text-[#8a641d] mr-1"></i>{{ $booking->booking_time }}
                                </span>
                                <span class="text-[11px] text-[#6f6248]">
                                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') : '' }}
                                </span>
                            </td>

                            <!-- Status Pill -->
                            <td class="px-4 py-3.5 text-right">
                                @php
                                    $statusClasses = [
                                        'pending' => 'border-[#8a641d] bg-[#8a641d]/10 text-[#f2d788]',
                                        'confirmed' => 'border-emerald-600/50 bg-emerald-950/40 text-emerald-400',
                                        'completed' => 'border-blue-600/50 bg-blue-950/40 text-blue-300',
                                        'cancelled' => 'border-[#a8342f] bg-[#7c1f22]/20 text-[#f0c9c9]',
                                    ];

                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'confirmed' => 'Đã xác nhận',
                                        'completed' => 'Hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                    ];

                                    $currentStatus = strtolower($booking->status);
                                @endphp

                                <span class="inline-block rounded-[2px] border px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$currentStatus] ?? 'border-[#3c2c15] text-[#6f6248]' }}">
                                    {{ $statusLabels[$currentStatus] ?? $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-[#6f6248]">
                                <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block text-[#3c2c15]"></i>
                                <p class="text-xs">Bạn chưa có lịch hẹn cắt tóc nào.</p>
                                <a href="{{ route('booking.create') }}" class="mt-3 inline-block text-xs font-bold text-[#8a641d] hover:text-[#f2d788] hover:underline">
                                    Đặt lịch hẹn đầu tiên ngay &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection