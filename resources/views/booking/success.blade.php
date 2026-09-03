@extends('layouts.app')

@section('title', 'Đặt lịch thành công - Tâm Barbershop')

@section('content')
<div class="max-w-xl mx-auto py-10 px-4 sm:px-6">

    <!-- SUCCESS BADGE HEADER -->
    <div class="text-center mb-8">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full border-2 border-[#8a641d] bg-[#171008] text-[#f2d788] shadow-2xl mb-4">
            <i class="fa-solid fa-circle-check text-3xl"></i>
        </div>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase">
            Đặt Lịch Thành Công!
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-[#f4ecd8]/70">
            Cảm ơn quý khách. Yêu cầu đặt lịch của bạn đã được ghi nhận vào hệ thống.
        </p>
    </div>

    <!-- VINTAGE RECEIPT CARD -->
    <div class="relative rounded-[2px] border border-[#3c2c15] bg-[#171008] p-6 sm:p-8 shadow-2xl overflow-hidden"
         style="box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 20px 50px -15px rgba(0,0,0,.9);">
        
        <!-- Barber Pole Stripe Top Border -->
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_12px,#f4ecd8_12px_24px,#171008_24px_36px)]"></div>

        <!-- Receipt Header -->
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-4 mb-5">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#6f6248]">Phiếu xác nhận</span>
                <p class="font-['Bebas_Neue'] text-xl tracking-wider text-[#f2d788]">#{{ $booking->booking_code }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block rounded-[2px] border border-[#8a641d] bg-[#8a641d]/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#f2d788]">
                    {{ $booking->status }}
                </span>
            </div>
        </div>

        <!-- Booking Details List -->
        <div class="space-y-3.5 text-xs">
            <div class="flex justify-between items-center py-1 border-b border-[#3c2c15]/50">
                <span class="text-[#6f6248] uppercase tracking-wider font-semibold">Khách hàng</span>
                <span class="font-bold text-[#f4ecd8]">{{ $booking->customer_name }}</span>
            </div>

            <div class="flex justify-between items-center py-1 border-b border-[#3c2c15]/50">
                <span class="text-[#6f6248] uppercase tracking-wider font-semibold">Số điện thoại</span>
                <span class="font-mono text-[#f4ecd8]">{{ $booking->customer_phone }}</span>
            </div>

            <div class="flex justify-between items-center py-1 border-b border-[#3c2c15]/50">
                <span class="text-[#6f6248] uppercase tracking-wider font-semibold">Dịch vụ</span>
                <span class="font-semibold text-[#f2d788]">{{ $booking->service->name }}</span>
            </div>

            <div class="flex justify-between items-center py-1 border-b border-[#3c2c15]/50">
                <span class="text-[#6f6248] uppercase tracking-wider font-semibold">Thợ phụ trách (Barber)</span>
                <span class="font-semibold text-[#f4ecd8] flex items-center gap-1.5">
                    <i class="fa-solid fa-scissors text-[10px] text-[#8a641d]"></i>
                    {{ $booking->barber->name }}
                </span>
            </div>

            <div class="flex justify-between items-center py-1 border-b border-[#3c2c15]/50">
                <span class="text-[#6f6248] uppercase tracking-wider font-semibold">Thời gian hẹn</span>
                <span class="font-bold text-[#f2d788]">
                    <i class="fa-regular fa-clock mr-1 text-[#8a641d]"></i>
                    {{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <!-- Note Box -->
        <div class="mt-6 rounded-[2px] border border-[#3c2c15] bg-[#0b0805] p-3 text-center text-[11px] text-[#6f6248]">
            <p class="flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-phone-volume text-[#8a641d]"></i>
                Tiệm sẽ liên hệ xác nhận với bạn qua số điện thoại đã đăng ký.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] py-2.5 px-4 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] transition-all hover:border-[#8a641d] hover:text-[#f2d788]">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Về trang chủ</span>
            </a>

            @auth
                <a href="{{ route('account.index') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 px-4 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110">
                    <i class="fa-solid fa-receipt text-[10px]"></i>
                    <span>Xem lịch sử</span>
                </a>
            @else
                <a href="{{ route('booking.create') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 px-4 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110">
                    <i class="fa-solid fa-calendar-plus text-[10px]"></i>
                    <span>Đặt lịch khác</span>
                </a>
            @endauth
        </div>

    </div>
</div>
@endsection