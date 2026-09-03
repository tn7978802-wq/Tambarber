@extends('layouts.app')

@section('title', 'Đăng ký - Barbershop')

@section('content')

    <!-- Khung bọc Auth -->
    <div class="max-w-2xl mx-auto my-10 p-8 bg-[#171008] border border-[#3c2c15] rounded-sm shadow-[0_0_0_1px_rgba(207,159,63,0.35),0_18px_40px_-20px_rgba(0,0,0,0.8)]">
        
        <!-- Thanh gạch Barber Pole Divider -->
        <div class="h-1 w-28 mx-auto mb-6 rounded-full bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)] shadow-md"></div>
        
        <h1 class="text-3xl font-bold text-center text-[#f2d788] uppercase mb-6 tracking-wide">Đăng ký tài khoản</h1>

        <!-- Thống kê lỗi validation nếu có -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-[#7c1f22]/20 border border-[#a8342f] text-[#f0c9c9] rounded-sm text-sm">
                <p class="font-semibold text-[#f2d788] mb-1">Không thể đăng ký:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Họ và tên -->
            <div>
                <label for="name" class="block text-sm font-medium text-[#6f6248] mb-1">Họ và tên</label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    placeholder="Nguyễn Văn A"
                    class="w-full px-3 py-2 bg-[#171008] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#6f6248] mb-1">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    placeholder="example@gmail.com"
                    class="w-full px-3 py-2 bg-[#171008] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                >
            </div>

            <!-- Số điện thoại -->
            <div>
                <label for="phone" class="block text-sm font-medium text-[#6f6248] mb-1">
                    Số điện thoại <span class="text-xs text-[#6f6248]/70">(không bắt buộc)</span>
                </label>
                <input 
                    id="phone" 
                    type="text" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    placeholder="0901234567"
                    class="w-full px-3 py-2 bg-[#171008] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f] placeholder-[#6f6248]/50"
                >
            </div>

            <!-- Mật khẩu -->
            <div>
                <label for="password" class="block text-sm font-medium text-[#6f6248] mb-1">Mật khẩu</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-3 py-2 bg-[#171008] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f]"
                >
            </div>

            <!-- Xác nhận mật khẩu -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[#6f6248] mb-1">Xác nhận mật khẩu</label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    required
                    class="w-full px-3 py-2 bg-[#171008] border border-[#3c2c15] text-[#f4ecd8] rounded-sm text-sm focus:outline-none focus:border-[#cf9f3f] focus:ring-1 focus:ring-[#cf9f3f]"
                >
            </div>

            <!-- Nút đăng ký -->
            <button 
                type="submit" 
                class="w-full mt-6 py-2.5 px-4 bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] font-semibold text-sm uppercase tracking-wider rounded-sm border border-[#8a641d] shadow-md hover:brightness-110 active:scale-[0.99] transition"
            >
                Đăng ký
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-[#6f6248]">
            Đã có tài khoản? 
            <a href="{{ route('login') }}" class="text-[#f2d788] hover:underline ml-1 font-medium">Đăng nhập ngay</a>
        </div>
    </div>

@endsection