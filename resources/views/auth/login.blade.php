@extends('layouts.app')

@section('title', 'Đăng nhập - Barbershop')

@section('content')
<div class="flex min-h-[calc(100vh-160px)] items-center justify-center px-4 py-12">
    <div class="auth-shell w-full max-w-2xl rounded-[2px] border bg-[#171008] p-6 shadow-2xl sm:p-8" 
         style="border-color: var(--rosewood-br, #3c2c15); box-shadow: 0 0 0 1px rgba(138,100,29,.25), 0 18px 40px -20px rgba(0,0,0,.8);">
        
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="font-['Bebas_Neue'] text-3xl tracking-wide text-[#f2d788]">Đăng nhập</h1>
            <p class="mt-1 text-xs text-[#6f6248]">Vui lòng nhập thông tin tài khoản của bạn</p>
        </div>

        <!-- Barber Pole Separator -->
        <div class="my-4 h-[2px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_10px,#f4ecd8_10px_20px,#171008_20px_30px)]"></div>

        <!-- Form Login -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Email / Phone -->
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]">
                    Email hoặc Số điện thoại
                </label>
                <input 
                    type="text" 
                    name="email" 
                    value="{{ old('email', 'tn7410311@gmail.com') }}" 
                    required 
                    autofocus
                    class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2.5 text-xs text-[#f4ecd8] placeholder-[#6f6248] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]"
                >
                @error('email')
                    <p class="mt-1 text-[11px] text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-[#f4ecd8]">
                    Mật khẩu
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2.5 text-xs text-[#f4ecd8] focus:border-[#8a641d] focus:outline-none focus:ring-1 focus:ring-[#8a641d]"
                >
                @error('password')
                    <p class="mt-1 text-[11px] text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs text-[#6f6248]">
                <label class="flex items-center gap-2 cursor-pointer hover:text-[#f4ecd8]">
                    <input type="checkbox" name="remember" class="rounded border-[#3c2c15] bg-[#0b0805] text-[#8a641d] focus:ring-[#8a641d]">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[#8a641d] hover:text-[#f2d788] hover:underline">Quên mật khẩu?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 text-xs font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110 active:scale-[0.99]">
                Đăng nhập
            </button>
        </form>

        <!-- Sub Links -->
        <div class="mt-6 border-t border-[#3c2c15] pt-4 text-center text-xs space-y-3">
            <div>
                <span class="text-[#6f6248]">Chưa có tài khoản?</span>
                <a href="{{ route('register') }}" class="ml-1 font-bold text-[#f2d788] hover:underline">Đăng ký ngay</a>
            </div>

            <!-- Nút đăng nhập Google đã khớp tên route google.login -->
            @if (Route::has('google.login'))
                <div>
                    <a href="{{ route('google.login') }}" class="inline-flex items-center gap-2 rounded border border-[#3c2c15] bg-[#0b0805] px-4 py-2 text-xs text-[#f4ecd8] transition-colors hover:border-[#8a641d] hover:text-[#f2d788]">
                        <i class="fa-brands fa-google text-red-500"></i>
                    </a>
                </div>
            @endif

            <div class="pt-2">
                @if (Route::has('system-owner.portal'))
                    <a href="{{ route('system-owner.portal') }}" class="text-[11px] text-[#8a641d] hover:text-[#f2d788] transition-colors">
                        Đăng nhập dành cho Quản lý tối cao &rarr;
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection