@extends('layouts.app')

@section('title', 'Đăng nhập Quản lý tối cao - Tâm Barbershop')

@section('content')
<div class="relative min-h-[calc(100vh-160px)] flex items-center justify-center px-4 py-12 overflow-hidden">
    
    <!-- EXECUTIVE AMBIENT CRIMSON & GOLD GLOWS -->
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-gradient-to-br from-[#7c1f22]/25 via-[#a8342f]/15 to-transparent rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-[#7c1f22]/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#cf9f3f]/15 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- MASTER SHELL CARD -->
    <div class="relative z-10 w-full max-w-xl rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-8 sm:p-10 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.95)] backdrop-blur-md transition-all duration-500 hover:border-[#f2d788]/60"
         style="box-shadow: 0 0 50px rgba(124,31,34,0.25), 0 0 20px rgba(138,100,29,0.15), inset 0 0 20px rgba(242,215,136,0.02);">

        <!-- CROWN BADGE TOP -->
        <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-[#070503] border border-[#a8342f] px-4 py-1 rounded-full shadow-[0_0_15px_rgba(168,52,47,0.4)] flex items-center gap-2">
            <i class="fa-solid fa-crown text-[11px] text-[#f2d788] animate-pulse"></i>
            <span class="text-[9px] font-extrabold uppercase tracking-[0.25em] text-[#f2d788]">Master Area</span>
        </div>

        <!-- HEADER -->
        <div class="pt-2 mb-8 text-center space-y-2">
            <h1 class="font-['Bebas_Neue'] text-4xl sm:text-5xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase drop-shadow-md">
                Chủ tiệm Đăng nhập
            </h1>
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#a8342f]">
                Nơi quản lý APP  &middot; Quyền Hạn Cao Nhất
            </p>

            <!-- BARBER POLE CRIMSON DIVIDER -->
            <div class="pt-2 flex items-center justify-center gap-3">
                <div class="h-[1px] w-12 bg-gradient-to-r from-transparent to-[#a8342f]"></div>
                <i class="fa-solid fa-shield-halved text-[10px] text-[#a8342f]"></i>
                <div class="h-[1px] w-12 bg-gradient-to-l from-transparent to-[#a8342f]"></div>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- EMAIL FIELD -->
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 flex items-center justify-between">
                    <span>Email Chủ Tiệm</span>
                    <i class="fa-solid fa-user-shield text-[#a8342f]"></i>
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="email"
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="master@barbershop.com"
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-3 text-xs text-[#f4ecd8] placeholder-[#4a3b22] shadow-inner transition-all duration-300 focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none"
                    >
                </div>
            </div>

            <!-- MASTER PASSWORD FIELD -->
            <div class="space-y-2">
                <label for="password" class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 flex items-center justify-between">
                    <span>Master Password</span>
                    <i class="fa-solid fa-key text-[#a8342f]"></i>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        required
                        placeholder="••••••••••••"
                        class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-4 py-3 text-xs text-[#f4ecd8] placeholder-[#4a3b22] shadow-inner transition-all duration-300 focus:border-[#a8342f] focus:ring-1 focus:ring-[#a8342f] focus:outline-none"
                    >
                </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="pt-2">
                <button type="submit" 
                        class="group relative w-full overflow-hidden rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] py-3.5 px-6 text-xs font-bold uppercase tracking-[0.2em] text-[#f4ecd8] shadow-[0_0_20px_rgba(124,31,34,0.4)] transition-all duration-300 hover:brightness-125 hover:shadow-[0_0_30px_rgba(168,52,47,0.6)] active:scale-[0.98]">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock text-[10px] transition-transform duration-300 group-hover:rotate-12"></i>
                        <span>Xác Nhận Đăng Nhập</span>
                    </span>
                    <!-- Hover shine animation -->
                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/30 to-transparent transition-transform duration-1000 group-hover:translate-x-full"></div>
                </button>
            </div>
        </form>

        <!-- FOOTER LINKS -->
        <div class="mt-8 pt-6 border-t border-[#3c2c15]/80 text-center">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center gap-2 text-[11px] font-semibold text-[#6f6248] hover:text-[#f2d788] transition-colors">
                <i class="fa-solid fa-arrow-left text-[9px]"></i>
                <span>Quay lại trang đăng nhập thường</span>
            </a>
        </div>

    </div>
</div>
@endsection