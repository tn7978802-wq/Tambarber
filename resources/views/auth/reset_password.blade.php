@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Barbershop')

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-2xl bg-[#171008] border border-[#3c2c15] p-6 md:p-8 rounded-sm shadow-[0_0_0_1px_rgba(207,159,63,0.35),0_18px_40px_-20px_rgba(0,0,0,0.8)]">
            
            <!-- Header & Divider -->
            <div class="text-center mb-6">
                <span class="text-xs uppercase tracking-widest text-[#6f6248] font-medium block mb-1">Bảo mật tài khoản</span>
                <h1 class="text-2xl font-bold text-[#f2d788] uppercase tracking-wide">Đặt lại mật khẩu</h1>
                <div class="h-1 w-20 mx-auto mt-3 rounded-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)] shadow-md"></div>
            </div>

            <!-- Form Đặt lại mật khẩu -->
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email (Readonly) -->
                <div>
                    <label for="email" class="block text-xs font-medium text-[#6f6248] mb-1.5">Email</label>
                    <input 
                        id="email"
                        type="email" 
                        name="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        readonly
                        class="w-full px-3.5 py-2 bg-[#0b0805]/60 border border-[#3c2c15] text-[#6f6248] cursor-not-allowed rounded-sm text-sm focus:outline-none"
                    >
                </div>

                <!-- Mật khẩu mới -->
                <div>
                    <label for="password" class="block text-xs font-medium text-[#6f6248] mb-1.5">Mật khẩu mới</label>
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        required 
                        placeholder="Nhập mật khẩu mới..."
                        class="w-full px-3.5 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                    >
                </div>

                <!-- Xác nhận mật khẩu mới -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-[#6f6248] mb-1.5">Xác nhận mật khẩu mới</label>
                    <input 
                        id="password_confirmation"
                        type="password" 
                        name="password_confirmation" 
                        required 
                        placeholder="Nhập lại mật khẩu mới..."
                        class="w-full px-3.5 py-2 bg-[#0b0805] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                    >
                </div>

                <!-- Nút Submit -->
                <button 
                    type="submit" 
                    class="w-full mt-2 py-2.5 px-4 bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] font-semibold text-sm uppercase tracking-wider rounded-sm border border-[#8a641d] shadow-md hover:brightness-110 active:scale-[0.99] transition"
                >
                    Cập nhật mật khẩu
                </button>
            </form>

        </div>
    </div>

@endsection