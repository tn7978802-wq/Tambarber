@extends('layouts.admin')

@section('title', 'Doanh thu theo Barber - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-chart-line text-xs"></i>
            </span>
            <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase">
                Doanh Thu Theo Barber
            </h1>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Tổng hợp khách vãng lai và khách đặt lịch online đã hoàn thành.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- FILTER FORM CARD -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl relative overflow-hidden transition-all duration-300 hover:border-[#a8342f]/50">
        
        <div class="flex items-center gap-2 mb-6 border-b border-[#3c2c15] pb-3">
            <i class="fa-solid fa-filter text-[#a8342f] text-sm"></i>
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                Bộ Lọc Thống Kê
            </h2>
        </div>

        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 items-end">
            <!-- Period Select -->
            <div class="space-y-1.5">
                <label for="period" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Xem theo
                </label>
                <select id="period" name="period"
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                    <option value="day" @selected(($period ?? '') === 'day')>Ngày</option>
                    <option value="month" @selected(($period ?? '') === 'month')>Tháng</option>
                    <option value="year" @selected(($period ?? '') === 'year')>Năm</option>
                </select>
            </div>

            <!-- Date Input -->
            <div class="space-y-1.5">
                <label for="date" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Thời gian
                </label>
                <input type="date" id="date" name="date" value="{{ $date ?? '' }}"
                       class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
            </div>

            <!-- Barber Select -->
            <div class="space-y-1.5">
                <label for="barber_id" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">
                    Barber
                </label>
                <select id="barber_id" name="barber_id"
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-2.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none transition-all">
                    <option value="all" @selected(($barberId ?? 'all') === 'all')>Tất cả Barber</option>
                    @foreach ($barbers ?? [] as $barber)
                        <option value="{{ $barber->id }}" @selected((string)($barberId ?? '') === (string)$barber->id)>
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-6 py-2.5 text-xs font-bold uppercase tracking-[0.15em] text-[#f4ecd8] shadow-[0_0_15px_rgba(124,31,34,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_25px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                    <span>Lọc Dữ Liệu</span>
                </button>
            </div>
        </form>
    </div>

    <!-- REVENUE DATA TABLE SECTION -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-list-check text-xs text-[#a8342f]"></i>
                Kết Quả Thống Kê
            </h2>
        </div>

        @include('admin.revenue._table', ['rows' => $rows, 'total' => $total])
    </div>

</div>
@endsection