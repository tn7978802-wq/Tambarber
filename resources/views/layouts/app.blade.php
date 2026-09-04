<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0b0805]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tâm Barbershop')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0b0805] text-[#f4ecd8] font-sans antialiased flex flex-col justify-between selection:bg-[#8a641d] selection:text-white">

    <!-- HEADER & MAIN PUBLIC NAV -->
    <header class="sticky top-0 z-50 border-b border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
            
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <div class="flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805]">
                    <i class="fa-solid fa-scissors text-lg"></i>
                </div>
                <span class="font-['Bebas_Neue'] text-3xl tracking-wider text-[#f2d788]">Tâm <span class="text-[#f4ecd8]">Barbershop</span></span>
            </a>

            <!-- NÚT 3 GẠCH CHO ĐIỆN THOẠI (CHỈ HIỂN THỊ TRÊN MÀN HÌNH MÁY TÍNH BẢNG / ĐIỆN THOẠI) -->
            <button id="mobileMenuBtn" type="button" class="lg:hidden p-2 text-[#f2d788] hover:text-white focus:outline-none" onclick="toggleMobileMenu()">
                <i id="mobileMenuIcon" class="fa-solid fa-bars text-2xl"></i>
            </button>

            <!-- NAVIGATION TOOLBAR (MÁY TÍNH - DESKTOP) -->
            <nav class="hidden lg:flex items-center gap-5 text-xs font-bold uppercase tracking-wider">
                <a href="{{ route('home') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('home') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Trang chủ</a>
                <a href="{{ route('about') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('about') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Giới thiệu</a>
                <a href="{{ route('hairstyles.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('hairstyles.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Kiểu tóc</a>
                <a href="{{ route('services.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('services.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Dịch vụ</a>
                <a href="{{ route('portfolio.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('portfolio.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Portfolio</a>
                <a href="{{ route('blog.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('blog.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Blog</a>
                <a href="{{ route('announcements.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('announcements.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Sự kiện</a>
                <a href="{{ route('contact.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('contact.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Liên hệ</a>

                <a href="{{ route('booking.create') }}" class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3.5 py-1.5 text-[#0b0805] shadow transition-all hover:brightness-110">Đặt lịch</a>

                <div class="h-4 w-[1px] bg-[#3c2c15]"></div>

                @auth
                    <!-- TÀI KHOẢN KHÁCH HÀNG / NGƯỜI DÙNG -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('account.index') }}" class="flex items-center gap-2 group">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=251b0e&color=f2d788' }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="h-7 w-7 rounded-full border border-[#8a641d] object-cover transition-transform group-hover:scale-105">
                            
                            <span class="text-[#f2d788] group-hover:underline {{ request()->routeIs('account.index') ? 'font-black' : '' }}">
                                {{ \Illuminate\Support\Str::limit(auth()->user()->fullname ?? auth()->user()->name, 12) }}
                            </span>
                        </a>

                        <a href="{{ route('settings') }}" 
                           title="Cài đặt tài khoản"
                           class="relative inline-flex h-7 w-7 items-center justify-center rounded-[2px] border border-[#3c2c15] bg-[#251b0e] text-[#f2d788] transition-all hover:border-[#8a641d] hover:bg-[#8a641d] hover:text-[#0b0805] group {{ request()->routeIs('settings*') ? 'border-[#8a641d] bg-[#8a641d] text-[#0b0805]' : '' }}">
                            <i class="fa-solid fa-gear text-xs transition-transform duration-500 group-hover:rotate-180"></i>
                        </a>

                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-[#8a641d] hover:text-[#f2d788]" title="Bảng quản trị Admin">
                                <i class="fa-solid fa-user-shield text-sm"></i>
                            </a>
                        @endif
                        
                        @if (auth()->user()->isSystemOwner())
                            <a href="{{ route('admin.system-owner.index') }}" class="text-[#a8342f] hover:text-red-400" title="Quản lý tối cao">
                                <i class="fa-solid fa-crown text-sm"></i>
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-[#6f6248] hover:text-red-400 transition-colors ml-1" title="Đăng xuất">
                                <i class="fa-solid fa-right-from-bracket text-sm"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[#f4ecd8] hover:text-[#f2d788]">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-3 py-1 text-[#f2d788] hover:border-[#8a641d]">Đăng ký</a>
                @endauth
            </nav>

        </div>

        <!-- MENU THẢ XUỐNG DÀNH CHO MOBILE -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-[#3c2c15] bg-[#171008] px-4 pt-3 pb-6 space-y-3 font-bold uppercase text-xs tracking-wider">
            <a href="{{ route('home') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('home') ? 'text-[#f2d788]' : '' }}">Trang chủ</a>
            <a href="{{ route('about') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('about') ? 'text-[#f2d788]' : '' }}">Giới thiệu</a>
            <a href="{{ route('hairstyles.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('hairstyles.*') ? 'text-[#f2d788]' : '' }}">Kiểu tóc</a>
            <a href="{{ route('services.index') }}" class="block py-2 rounded bg-[#251b0e] px-3 py-2 text-[#f2d788] {{ request()->routeIs('services.*') ? 'text-[#f2d788]' : '' }}">Dịch vụ</a>
            <a href="{{ route('portfolio.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('portfolio.*') ? 'text-[#f2d788]' : '' }}">Portfolio</a>
            <a href="{{ route('blog.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('blog.*') ? 'text-[#f2d788]' : '' }}">Blog</a>
            <a href="{{ route('announcements.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('announcements.*') ? 'text-[#f2d788]' : '' }}">Sự kiện</a>
            <a href="{{ route('contact.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('contact.*') ? 'text-[#f2d788]' : '' }}">Liên hệ</a>

            <div class="pt-2 border-t border-[#3c2c15]/60 space-y-3">
                <a href="{{ route('booking.create') }}" class="block text-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 text-[#0b0805]">
                    Đặt lịch ngay
                </a>

                @auth
                    <a href="{{ route('account.index') }}" class="flex items-center gap-3 py-2 text-[#f2d788]">
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=251b0e&color=f2d788' }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-8 w-8 rounded-full border border-[#8a641d] object-cover">
                        <span>Tài khoản: {{ auth()->user()->fullname ?? auth()->user()->name }}</span>
                    </a>

                    <a href="{{ route('settings') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788]">
                        <i class="fa-solid fa-gear mr-2 text-[#f2d788]"></i> Cài đặt tài khoản
                    </a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-[#8a641d] hover:text-[#f2d788]">
                            <i class="fa-solid fa-user-shield mr-2"></i> Trang quản trị Admin
                        </a>
                    @endif

                    @if (auth()->user()->isSystemOwner())
                        <a href="{{ route('admin.system-owner.index') }}" class="block py-2 text-[#a8342f] hover:text-red-400">
                            <i class="fa-solid fa-crown mr-2"></i> Trang Quản lý tối cao
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-red-400 hover:text-red-300 flex items-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-center text-[#f4ecd8] hover:text-[#f2d788]">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block text-center rounded-[2px] border border-[#3c2c15] bg-[#251b0e] py-2 text-[#f2d788]">Đăng ký</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- BARBER POLE SEPARATOR -->
    <div class="h-[3px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)]"></div>

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-[#3c2c15] bg-[#171008] py-8 text-center text-xs text-[#6f6248]">
        <p>&copy; {{ date('Y') }} Tâm Barbershop. All rights reserved.</p>
    </footer>

    <!-- SCRIPT XỬ LÝ ĐÓNG/MỞ MENU MOBILE -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('mobileMenuIcon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        }
    </script>

    @yield('scripts')
</body>
</html>