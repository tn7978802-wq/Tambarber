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

    <style>
        .nav-item {
            position: relative;
            padding-bottom: 8px;
        }

        .nav-dropdown {
            position: absolute;
            left: 0;
            top: calc(100% - 2px);
            opacity: 0;
            visibility: hidden;
            transform: translateY(6px);
            transition: opacity 0.15s ease, transform 0.15s ease, visibility 0.15s ease;
            pointer-events: none;
            z-index: 60;
        }

        .nav-item.is-open > .nav-dropdown,
        .nav-item:hover > .nav-dropdown,
        .nav-item:focus-within > .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }
    </style>
</head>
<body class="min-h-screen bg-[#0b0805] text-[#f4ecd8] font-sans antialiased flex flex-col justify-between selection:bg-[#8a641d] selection:text-white">

    <!-- HEADER & MAIN PUBLIC NAV -->
    <header class="sticky top-0 z-50 border-b border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md">
        <div class="max mx-auto flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
            
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-[0_0_15px_rgba(207,159,63,0.3)]">
                    <i class="fa-solid fa-scissors text-2xl"></i>
                </div>
                <div class="leading-none">
                    <div class="font-['Bebas_Neue'] text-[2.1rem] tracking-[0.12em] text-[#f2d788]">TÂM</div>
                    <div class="mt-1 font-['Bebas_Neue'] text-[1.1rem] tracking-[0.18em] text-[#f4ecd8]">BARBERSHOP</div>
                </div>
            </a>

            <!-- NÚT 3 GẠCH CHO ĐIỆN THOẠI (CHỈ HIỂN THỊ TRÊN MÀN HÌNH MÁY TÍNH BẢNG / ĐIỆN THOẠI) -->
            <button id="mobileMenuBtn" type="button" class="lg:hidden p-2 text-[#f2d788] hover:text-white focus:outline-none" onclick="toggleMobileMenu()">
                <i id="mobileMenuIcon" class="fa-solid fa-bars text-2xl"></i>
            </button>

            <!-- NAVIGATION TOOLBAR (MÁY TÍNH - DESKTOP) -->
            <nav class="hidden lg:flex items-center gap-4 text-[10px] font-bold uppercase tracking-[0.22em]">
                <ul class="flex items-center gap-1 list-none">
                    <li class="nav-item group relative">
                        <a href="{{ route('home') }}" class="flex items-center px-2 py-2 text-[#f4ecd8] transition-colors hover:text-[#f2d788] {{ request()->routeIs('home') ? 'text-[#f2d788]' : '' }}">
                            Home
                        </a>
                        <ul class="nav-dropdown absolute left-0 top-full z-50 mt-2 min-w-[180px] rounded-[2px] border border-[#3c2c15] bg-[#171008] p-1 shadow-2xl">
                            <li><a href="{{ route('home') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('home') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Trang chủ</a></li>
                            <li><a href="{{ route('about') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('about') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Giới thiệu</a></li>
                            <li><a href="{{ route('contact.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('contact.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Liên hệ</a></li>
                        </ul>
                    </li>

                    <li class="nav-item group relative">
                        <a href="{{ route('hairstyles.index') }}" class="flex items-center px-2 py-2 text-[#f4ecd8] transition-colors hover:text-[#f2d788] {{ request()->routeIs('hairstyles.*') ? 'text-[#f2d788]' : '' }}">
                            Styles
                        </a>
                        <ul class="nav-dropdown absolute left-0 top-full z-50 mt-2 min-w-[180px] rounded-[2px] border border-[#3c2c15] bg-[#171008] p-1 shadow-2xl">
                            <li><a href="{{ route('hairstyles.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('hairstyles.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Kiểu tóc</a></li>
                            <li><a href="{{ route('services.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('services.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Dịch vụ</a></li>
                            <li><a href="{{ route('portfolio.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('portfolio.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Tác phẩm</a></li>
                        </ul>
                    </li>

                    <li class="nav-item group relative">
                        <a href="{{ route('blog.index') }}" class="flex items-center px-2 py-2 text-[#f4ecd8] transition-colors hover:text-[#f2d788] {{ request()->routeIs('blog.*') ? 'text-[#f2d788]' : '' }}">
                            Blog
                        </a>
                        <ul class="nav-dropdown absolute left-0 top-full z-50 mt-2 min-w-[180px] rounded-[2px] border border-[#3c2c15] bg-[#171008] p-1 shadow-2xl">
                            <li><a href="{{ route('blog.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('blog.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Tin tức</a></li>
                            <li><a href="{{ route('announcements.index') }}" class="block rounded-[2px] px-3 py-2 text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788] {{ request()->routeIs('announcements.*') ? 'bg-[#251b0e] text-[#f2d788]' : '' }}">Sự kiện</a></li>
                        </ul>
                    </li>
                </ul>

                <a href="{{ route('booking.create') }}" class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3.5 py-1.5 text-[#0b0805] shadow transition-all hover:brightness-110">ĐẶT LỊCH NGAY</a>

                <div class="h-4 w-[1px] bg-[#3c2c15]"></div>

                @auth
                    <!-- TÀI KHOẢN KHÁCH HÀNG / NGƯỜI DÙNG -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('account.index') }}" class="flex items-center gap-2 group">
                            <img src="{{ auth()->user()->avatar ? (str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/' . auth()->user()->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=251b0e&color=f2d788' }}" 
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

                        <form action="{{ route('logout', [], false) }}" method="POST" class="inline">
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
                        <img src="{{ auth()->user()->avatar ? (str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : asset('storage/' . auth()->user()->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=251b0e&color=f2d788' }}" 
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

                    <form action="{{ route('logout', [], false) }}" method="POST" class="pt-1">
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
        @if (session('success'))
            <div class="max-w-6xl mx-auto px-4 pt-6">
                <div class="rounded-[2px] border border-emerald-600/50 bg-emerald-950/40 p-4 text-emerald-300 text-sm shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="max-w-6xl mx-auto px-4 pt-6">
                <div class="rounded-[2px] border border-rose-600/50 bg-rose-950/40 p-4 text-rose-300 text-sm shadow-lg">
                    <strong class="block mb-2 font-bold flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-base text-rose-400"></i> Đã có lỗi xảy ra:
                    </strong>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    
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

    <script>
        (function () {
            const items = document.querySelectorAll('.nav-item');

            items.forEach((item) => {
                const dropdown = item.querySelector('.nav-dropdown');
                if (!dropdown) return;

                let hideTimer = null;

                const clearHide = () => {
                    if (hideTimer) {
                        clearTimeout(hideTimer);
                        hideTimer = null;
                    }
                };

                const closeOthers = () => {
                    items.forEach((otherItem) => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('is-open');
                        }
                    });
                };

                item.addEventListener('mouseenter', () => {
                    clearHide();
                    closeOthers();
                    item.classList.add('is-open');
                });

                item.addEventListener('mouseleave', () => {
                    clearHide();
                    hideTimer = setTimeout(() => {
                        if (!item.matches(':hover') && !dropdown.matches(':hover')) {
                            item.classList.remove('is-open');
                        }
                    }, 120);
                });

                dropdown.addEventListener('mouseenter', () => clearHide());
                dropdown.addEventListener('mouseleave', () => {
                    clearHide();
                    hideTimer = setTimeout(() => {
                        if (!item.matches(':hover') && !dropdown.matches(':hover')) {
                            item.classList.remove('is-open');
                        }
                    }, 120);
                });
            });
        })();
    </script>

    @yield('scripts')
</body>
</html>