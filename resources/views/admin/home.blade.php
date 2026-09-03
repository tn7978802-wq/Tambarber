@extends('layouts.admin')

@section('title', 'Dashboard - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION & RANGE FILTER -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                        <i class="fa-solid fa-chart-line text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Tổng quan vận hành</span>
                        <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                            Dashboard
                        </h1>
                    </div>
                </div>
                <p class="text-xs text-[#f4ecd8]/70">
                    Báo cáo hiệu suất kinh doanh, xu hướng đặt lịch và hoạt động tổng thể của tiệm.
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center gap-2 bg-[#070503] p-1.5 rounded-[2px] border border-[#3c2c15]">
                @foreach (['day' => 'Ngày', 'week' => 'Tuần', 'month' => 'Tháng'] as $key => $label)
                    <a href="{{ route('admin.dashboard', ['range' => $key]) }}"
                       class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider rounded-[2px] transition-all {{ $dashboardFilter === $key ? 'bg-gradient-to-r from-[#7c1f22] to-[#8a641d] text-[#f2d788] border border-[#f2d788]/50 shadow-[0_0_10px_rgba(168,52,47,0.4)]' : 'text-[#f4ecd8]/60 hover:text-[#f2d788] hover:bg-[#171008]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- SUMMARY METRICS GRID -->
    <div class="space-y-3">
        <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
            <i class="fa-solid fa-bolt text-xs text-[#a8342f]"></i>
            Tổng Quan ({{ $dashboardFilterLabel }})
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($summaryMetrics as $metric)
                <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-5 shadow-lg flex flex-col justify-between space-y-3 hover:border-[#a8342f]/50 transition-all group">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248] group-hover:text-[#8a641d] transition-colors">
                        {{ $metric['label'] }}
                    </span>
                    
                    <div class="space-y-1">
                        <div class="font-['Bebas_Neue'] text-3xl tracking-wider text-[#f2d788]">
                            {{ $metric['value'] }}
                        </div>
                        
                        @if ($metric['delta'])
                            <div class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-400/90">
                                <i class="fa-solid fa-arrow-trend-up text-[9px]"></i>
                                <span>{{ $metric['delta']['text'] }} so với kỳ trước</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TOP SERVICES & TOP BARBERS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- TOP SERVICES -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
            <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
                <i class="fa-solid fa-[#a8342f] fa-scissors text-[#a8342f] text-sm"></i>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                    Dịch Vụ Được Đặt Nhiều Nhất
                </h2>
            </div>

            <ol class="space-y-3">
                @forelse ($topServices as $index => $item)
                    <li class="flex items-center justify-between p-3 rounded-[2px] border border-[#3c2c15]/60 bg-[#070503] hover:border-[#8a641d] transition-all">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#171008] border border-[#3c2c15] font-['Bebas_Neue'] text-xs font-bold text-[#f2d788]">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-semibold text-[#f4ecd8]">{{ $item->label }}</span>
                        </div>
                        <span class="rounded-[2px] border border-[#8a641d]/40 bg-[#171008] px-2.5 py-1 text-[11px] font-bold text-[#f2d788]">
                            {{ $item->value }} lượt
                        </span>
                    </li>
                @empty
                    <li class="py-6 text-center text-[#6f6248] italic text-xs">Chưa có dữ liệu.</li>
                @endforelse
            </ol>
        </div>

        <!-- TOP BARBERS -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
            <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
                <i class="fa-solid fa-user-tie text-[#a8342f] text-sm"></i>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                    Barber Đông Khách Nhất
                </h2>
            </div>

            <ol class="space-y-3">
                @forelse ($topBarbers as $index => $item)
                    <li class="flex items-center justify-between p-3 rounded-[2px] border border-[#3c2c15]/60 bg-[#070503] hover:border-[#8a641d] transition-all">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#171008] border border-[#3c2c15] font-['Bebas_Neue'] text-xs font-bold text-[#f2d788]">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-semibold text-[#f4ecd8]">{{ $item->label }}</span>
                        </div>
                        <span class="rounded-[2px] border border-[#8a641d]/40 bg-[#171008] px-2.5 py-1 text-[11px] font-bold text-[#f2d788]">
                            {{ $item->value }} lượt
                        </span>
                    </li>
                @empty
                    <li class="py-6 text-center text-[#6f6248] italic text-xs">Chưa có dữ liệu.</li>
                @endforelse
            </ol>
        </div>

    </div>

    <!-- POPULAR TIME SLOTS -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-clock text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Khung Giờ Đặt Lịch Phổ Biến
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @foreach ($hourDistribution as $slot)
                <div class="p-3 rounded-[2px] border border-[#3c2c15] bg-[#070503] text-center space-y-1 hover:border-[#8a641d] transition-all">
                    <span class="text-xs font-bold text-[#f4ecd8] font-mono block">{{ $slot->label }}</span>
                    <span class="text-[11px] font-semibold text-[#f2d788] block">{{ $slot->total }} lượt</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- UPCOMING BOOKINGS & QUICK ACTIONS TABLE CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-6">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-xs text-[#a8342f]"></i>
                Lịch Hẹn Sắp Tới
            </h2>
            <a href="{{ route('admin.bookings.index') }}" 
               class="text-xs font-bold uppercase tracking-wider text-[#f2d788] hover:text-[#fff5d6] hover:underline flex items-center gap-1">
                <span>Xem toàn bộ lịch</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
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
                        <th class="py-3 px-4 text-right">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @forelse ($upcomingBookings as $booking)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-[#f2d788] whitespace-nowrap">
                                {{ $booking->booking_code }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-[#f4ecd8]">
                                {{ $booking->customer_name }}
                            </td>
                            <td class="py-3 px-4 text-[#f4ecd8]/90">
                                {{ $booking->service_name }}
                            </td>
                            <td class="py-3 px-4 text-[#f2d788]">
                                {{ $booking->barber_name }}
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap font-medium text-[#f4ecd8]/80">
                                {{ $booking->booking_time }} <span class="text-[#6f6248] mx-0.5">•</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#6f6248] italic">
                                <i class="fa-solid fa-calendar-xmark text-2xl mb-2 block"></i>
                                Không có lịch hẹn nào sắp tới.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- QUICK MANAGEMENT LINKS -->
        <div class="pt-4 border-t border-[#3c2c15] flex flex-wrap items-center gap-4 text-xs font-semibold">
            <span class="text-[#6f6248] uppercase tracking-wider text-[10px]">Lối tắt quản lý:</span>
            <a href="{{ route('admin.barbers.index') }}" class="text-[#f2d788] hover:underline flex items-center gap-1.5">
                <i class="fa-solid fa-user-gear text-[10px] text-[#a8342f]"></i>
                <span>Quản lý Barber</span>
            </a>
            <span class="text-[#3c2c15]">•</span>
            <a href="{{ route('admin.announcements.index') }}" class="text-[#f2d788] hover:underline flex items-center gap-1.5">
                <i class="fa-solid fa-bullhorn text-[10px] text-[#a8342f]"></i>
                <span>Đăng Trạng thái &amp; Sự kiện</span>
            </a>
        </div>

    </div>

</div>
@endsection