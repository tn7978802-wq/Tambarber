@extends('layouts.app')

@section('title', 'Đặt lịch - Tâm Barbershop')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <!-- HERO HEADER -->
    <div class="mb-8 text-center">
        <span class="text-[11px] font-bold uppercase tracking-widest text-[#6f6248]">Dễ dàng &amp; Nhanh chóng</span>
        <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-wider text-[#f2d788] uppercase mb-2">
            Đặt Lịch Cắt Tóc
        </h1>
        <p class="text-xs sm:text-sm text-[#f4ecd8]/70">
            Chỉ với 5 bước đơn giản để giữ chỗ dịch vụ tại Tâm Barbershop
        </p>
        <div class="my-4 h-[2px] w-32 mx-auto bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>
    </div>

    <div class="space-y-6">

        <!-- BƯỚC 1: LỌC BARBER & NGÀY (FORM GET) -->
        <form action="{{ route('booking.create') }}" method="GET" class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-xl"
              style="box-shadow: 0 0 0 1px rgba(138,100,29,.2), 0 10px 25px -10px rgba(0,0,0,.8);">
            
            <div class="flex items-center gap-2 mb-4">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] font-['Bebas_Neue'] text-base font-bold text-[#0b0805]">
                    01
                </span>
                <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                    Chọn Barber &amp; Ngày cắt
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1.5">
                        Thợ cắt (Barber)
                    </label>
                    <select name="barber_id" onchange="this.form.submit()" 
                            class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2.5 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                        <option value="">-- Chọn barber phụ trách --</option>
                        @foreach ($barbers as $barber)
                            <option value="{{ $barber->id }}" @selected((string) $selectedBarberId === (string) $barber->id)>
                                {{ $barber->name }} ({{ $barber->title }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1.5">
                        Ngày hẹn
                    </label>
                    <input type="date" name="date" value="{{ $selectedDate }}" min="{{ now()->toDateString() }}" onchange="this.form.submit()"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                </div>
            </div>

            <input type="hidden" name="service_id" value="{{ $selectedServiceId }}">
            <noscript>
                <button type="submit" class="mt-3 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-4 py-1.5 text-xs font-bold text-[#f2d788]">
                    Cập nhật giờ trống
                </button>
            </noscript>
        </form>

        <!-- FORM CHÍNH: ĐẶT LỊCH (FORM POST) -->
        <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Hidden Inputs giữ state -->
            <input type="hidden" name="barber_id" value="{{ $selectedBarberId }}">
            <input type="hidden" name="booking_date" value="{{ $selectedDate }}">

            <!-- BƯỚC 2: CHỌN DỊCH VỤ -->
            <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-xl">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] font-['Bebas_Neue'] text-base font-bold text-[#0b0805]">
                        02
                    </span>
                    <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                        Chọn dịch vụ
                    </h2>
                </div>

                <select name="service_id" required 
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2.5 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                    <option value="">-- Vui lòng chọn dịch vụ --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected((string) $selectedServiceId === (string) $service->id)>
                            {{ $service->name }} - {{ number_format((float) $service->price, 0, ',', '.') }}đ ({{ $service->duration_minutes }} phút)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- BƯỚC 3: XÁC NHẬN BARBER & NGÀY -->
            <div class="rounded-[2px] border border-[#3c2c15] bg-[#251b0e]/60 p-4 text-xs text-[#f4ecd8] flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#8a641d] bg-[#0b0805] font-['Bebas_Neue'] text-xs text-[#f2d788]">
                        03
                    </span>
                    <span class="font-bold text-[#6f6248] uppercase tracking-wider">Thông tin đã chọn:</span>
                </div>
                <div class="flex items-center gap-4">
                    <span>Barber: <strong class="text-[#f2d788]">{{ optional($barbers->firstWhere('id', (int) $selectedBarberId))->name ?? 'Chưa chọn (ở bước 1)' }}</strong></span>
                    <span class="text-[#3c2c15]">•</span>
                    <span>Ngày: <strong class="text-[#f2d788]">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') : 'Chưa chọn' }}</strong></span>
                </div>
            </div>

            <!-- BƯỚC 4: CHỌN GIỜ -->
            <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-xl">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] font-['Bebas_Neue'] text-base font-bold text-[#0b0805]">
                        04
                    </span>
                    <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                        Khung giờ còn trống
                    </h2>
                </div>

                @if(empty($timeSlots))
                    <p class="text-xs text-[#6f6248] italic">Vui lòng chọn Barber và Ngày ở bước 1 để hiển thị khung giờ còn trống.</p>
                @else
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5">
                        @foreach ($timeSlots as $slot)
                            @php $isTaken = in_array($slot, $bookedSlots, true); @endphp
                            <label class="relative block cursor-pointer select-none">
                                <input type="radio" name="booking_time" value="{{ $slot }}" @disabled($isTaken) required class="peer sr-only">
                                
                                <div class="flex flex-col items-center justify-center rounded-[2px] border border-[#3c2c15] bg-[#0b0805] py-2 px-1 text-center transition-all
                                            peer-checked:border-[#f2d788] peer-checked:bg-[#8a641d] peer-checked:text-[#0b0805] peer-checked:font-bold
                                            hover:border-[#8a641d] 
                                            peer-disabled:cursor-not-allowed peer-disabled:opacity-40 peer-disabled:bg-[#171008] peer-disabled:border-[#251b0e]">
                                    <span class="font-['Bebas_Neue'] text-lg tracking-wider">{{ $slot }}</span>
                                    <span class="text-[9px] uppercase tracking-widest {{ $isTaken ? 'text-red-400' : 'text-[#6f6248] peer-checked:text-[#0b0805]' }}">
                                        {{ $isTaken ? 'Đã kín' : 'Còn trống' }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- BƯỚC 5: THÔNG TIN LIÊN HỆ -->
            <div class="rounded-[2px] border border-[#3c2c15] bg-[#171008] p-5 shadow-xl space-y-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] font-['Bebas_Neue'] text-base font-bold text-[#0b0805]">
                        05
                    </span>
                    <h2 class="font-['Bebas_Neue'] text-xl tracking-wide text-[#f2d788] uppercase">
                        Thông tin khách hàng
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1">
                            Họ và tên <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->fullname ?? '') }}" required placeholder="Nguyễn Văn A"
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1">
                            Số điện thoại <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required placeholder="0901234567"
                               class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1">
                        Địa chỉ Email <span class="text-[#6f6248] font-normal">(Không bắt buộc)</span>
                    </label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" placeholder="email@example.com"
                           class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#6f6248] mb-1">
                        Ghi chú thêm
                    </label>
                    <textarea name="note" rows="2" placeholder="Yêu cầu đặc biệt về kiểu tóc hoặc lời nhắn cho Barber..."
                              class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]">{{ old('note') }}</textarea>
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button type="submit" 
                    class="w-full rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-3.5 text-sm font-bold uppercase tracking-widest text-[#0b0805] transition-all hover:brightness-110 active:scale-[0.99] shadow-2xl flex items-center justify-center gap-2">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Xác nhận đặt lịch ngay</span>
            </button>

        </form>
    </div>

</div>
@endsection