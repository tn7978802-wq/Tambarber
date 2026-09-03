@extends('layouts.app')

@section('title', 'Quên mật khẩu - Barbershop')

@section('content')
<div class="flex min-h-[calc(100vh-160px)] items-center justify-center px-4 py-12">
    <div class="auth-shell w-full max-w-2xl rounded-[2px] border bg-[#171008] p-6 shadow-2xl sm:p-8" 
         style="border-color: var(--rosewood-br, #3c2c15); box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788]">Khôi phục mật khẩu</h1>
            <p class="mt-1 text-xs leading-relaxed text-[#6f6248]">
                Nhập email đã đăng ký tài khoản. Chúng tôi sẽ gửi liên kết để bạn thiết lập lại mật khẩu.
            </p>
        </div>

        <!-- Barber Pole Separator -->
        <div class="my-4 h-[2px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        <!-- Status Alert -->
        @if (session('status'))
            <div class="mb-4 rounded border border-emerald-900/50 bg-emerald-950/40 p-3 text-center text-xs font-semibold text-emerald-400">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Forgot Password -->
        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]">
                    Email đã đăng ký
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="your@email.com"
                    class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2.5 text-xs text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]"
                >
                @error('email')
                    <p class="mt-1 text-[11px] text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110 active:scale-[0.99]">
                Gửi liên kết đặt lại mật khẩu
            </button>
        </form>

        <!-- Sub Links -->
        <div class="mt-6 border-t border-[#3c2c15] pt-4 text-center text-xs">
            <a href="{{ route('login') }}" class="text-[#6f6248] transition-colors hover:text-[#f2d788]">
                &larr; Quay lại đăng nhập
            </a>
        </div>

    </div>
</div>
@endsection