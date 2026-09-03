@extends('layouts.app')

@section('title', 'Xác thực OTP - Barbershop')

@section('content')
<div class="flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
    <div class="auth-shell w-full max-w-md rounded-[2px] border bg-[#171008] p-6 text-center shadow-2xl sm:p-8" 
         style="border-color: var(--rosewood-br, #3c2c15); box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        
        <!-- Header -->
        <div class="mb-4">
            <h1 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788]">Xác thực OTP</h1>
            <p class="mt-1 text-xs text-[#6f6248]">
                Vui lòng nhập mã 6 số chúng tôi vừa gửi đến email của bạn
            </p>
        </div>

        <!-- Barber Pole Separator -->
        <div class="my-4 h-[2px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        <!-- Session Flash Messages -->
        @if (session('success'))
            <div class="mb-4 rounded-[2px] border border-[#8a641d] bg-[#8a641d]/10 p-2.5 text-xs text-[#f2d788]">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/20 p-2.5 text-xs text-[#f0c9c9]">
                {{ session('error') }}
            </div>
        @endif

        <!-- Countdown Timer -->
        <div class="mb-6 flex flex-col items-center justify-center gap-1 rounded-[2px] border border-[#3c2c15] bg-[#0b0805] py-3">
            <span class="text-[11px] font-semibold uppercase tracking-wider text-[#6f6248]">Thời gian còn lại</span>
            <span id="countdown" class="font-['Bebas_Neue'] text-3xl tracking-widest text-[#f2d788]">05:00</span>
        </div>

        <!-- OTP Form -->
        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]">
                    Mã xác thực (6 chữ số)
                </label>
                <input 
                    type="text" 
                    name="otp" 
                    maxlength="6" 
                    required 
                    autofocus 
                    autocomplete="off"
                    placeholder="••••••"
                    class="otp-input w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] py-3 text-center font-['Bebas_Neue'] text-3xl tracking-[0.6em] text-[#f2d788] placeholder-[#3c2c15] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]"
                >
                @error('otp')
                    <p class="mt-1.5 text-[11px] text-[#a8342f]">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110 active:scale-[0.99]">
                Xác thực ngay
            </button>
        </form>

        <!-- Footer Resend Link -->
        <div class="mt-6 border-t border-[#3c2c15] pt-4 text-xs text-[#6f6248]">
            Chưa nhận được mã? 
            <a href="{{ route('otp.send') }}" class="ml-1 font-bold text-[#f2d788] transition-colors hover:text-[#cf9f3f] hover:underline">
                Gửi lại OTP
            </a>
        </div>

    </div>
</div>

<script>
    (function () {
        var expiresAt = {{ $expiresAt }};
        var el = document.getElementById('countdown');

        function tick() {
            var now = Math.floor(Date.now() / 1000);
            var left = expiresAt - now;

            if (left <= 0) {
                el.textContent = '00:00';
                el.classList.add('text-[#a8342f]');
                return;
            }

            var m = Math.floor(left / 60).toString().padStart(2, '0');
            var s = (left % 60).toString().padStart(2, '0');
            el.textContent = m + ':' + s;
            setTimeout(tick, 1000);
        }

        tick();
    })();
</script>
@endsection