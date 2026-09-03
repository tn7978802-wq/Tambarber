@extends('layouts.admin')

@section('title', 'Quản lý Lịch hẹn - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-calendar-check text-xs"></i>
            </span>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Quản trị hệ thống</span>
                <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                    Quản Lý Lịch Hẹn
                </h1>
            </div>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Theo dõi, lọc và xử lý các lịch hẹn cắt tóc từ khách hàng. Cập nhật trạng thái xác nhận, hoàn thành hoặc hủy đơn nhanh chóng.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- FILTER BAR CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-5 shadow-2xl transition-all hover:border-[#a8342f]/50">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            
            <!-- Status Select -->
            <div class="space-y-1.5">
                <label for="status" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Lọc theo trạng thái
                </label>
                <select id="status" name="status" 
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all cursor-pointer">
                    <option value="">Tất cả trạng thái</option>
                    @foreach (['pending' => 'Chờ xác nhận', 'confirmed' => 'Đã xác nhận', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã huỷ'] as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Input -->
            <div class="space-y-1.5">
                <label for="date" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Lọc theo ngày
                </label>
                <input type="date" id="date" name="date" value="{{ $filters['date'] ?? '' }}"
                       class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-6 py-2 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>Áp Dụng Lọc</span>
                </button>
            </div>
        </form>
    </div>

    <!-- BOOKINGS TABLE CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-list text-xs text-[#a8342f]"></i>
                Danh Sách Lịch Hẹn
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Mã lịch</th>
                        <th class="py-3 px-4">Khách hàng</th>
                        <th class="py-3 px-4">Dịch vụ</th>
                        <th class="py-3 px-4">Barber</th>
                        <th class="py-3 px-4">Thời gian</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-[#171008] transition-colors">
                            
                            <!-- Booking Code -->
                            <td class="py-3 px-4 font-mono font-bold text-[#f2d788] whitespace-nowrap">
                                {{ $booking->booking_code }}
                            </td>

                            <!-- Customer Info -->
                            <td class="py-3 px-4 leading-relaxed">
                                <div class="font-bold text-[#f4ecd8]">{{ $booking->customer_name }}</div>
                                <div class="text-[11px] text-[#6f6248] font-mono">{{ $booking->customer_phone }}</div>
                            </td>

                            <!-- Service -->
                            <td class="py-3 px-4 text-[#f4ecd8]/90 font-medium">
                                {{ $booking->service->name }}
                            </td>

                            <!-- Barber -->
                            <td class="py-3 px-4 text-[#f2d788]">
                                {{ $booking->barber->name }}
                            </td>

                            <!-- Booking Time -->
                            <td class="py-3 px-4 whitespace-nowrap font-medium text-[#f4ecd8]/80">
                                {{ $booking->booking_time }} <span class="text-[#6f6248] mx-0.5">•</span> {{ $booking->booking_date->format('d/m/Y') }}
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3 px-4 whitespace-nowrap">
                                @switch($booking->status)
                                    @case('pending')
                                        <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-amber-500/40 bg-amber-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                            Chờ xác nhận
                                        </span>
                                        @break
                                    @case('confirmed')
                                        <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-sky-500/40 bg-sky-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-sky-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                            Đã xác nhận
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-emerald-500/40 bg-emerald-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                            Hoàn thành
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-red-500/40 bg-red-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-red-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                            Đã huỷ
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center gap-1.5 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                                            {{ $booking->status }}
                                        </span>
                                @endswitch
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3 px-4 text-right space-x-1.5 whitespace-nowrap">
                                
                                <!-- Confirm Action -->
                                @if ($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline-block">
                                        @csrf 
                                        @method('PUT')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-sky-600 bg-sky-950/50 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-sky-300 transition-all hover:bg-sky-600 hover:text-white">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                            <span>Xác nhận</span>
                                        </button>
                                    </form>
                                @endif

                                <!-- Complete Action -->
                                @if ($booking->status === 'confirmed')
                                    <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="inline-block">
                                        @csrf 
                                        @method('PUT')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-[#8a641d] bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-[#f2d788] transition-all hover:brightness-125">
                                            <i class="fa-solid fa-flag-checkered text-[10px]"></i>
                                            <span>Hoàn thành</span>
                                        </button>
                                    </form>
                                @endif

                                <!-- Cancel Action -->
                                @if (in_array($booking->status, ['pending', 'confirmed']))
                                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn huỷ lịch hẹn này?')">
                                        @csrf 
                                        @method('PUT')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 transition-all hover:bg-[#a8342f] hover:text-white">
                                            <i class="fa-solid fa-xmark text-[10px]"></i>
                                            <span>Huỷ</span>
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-calendar-xmark text-2xl mb-2 block"></i>
                                Chưa có lịch hẹn nào khớp với bộ lọc.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $bookings->links() }}
        </div>
    </div>

</div>
@endsection