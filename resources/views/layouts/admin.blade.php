<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#0b0805]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') - Tâm Barbershop Admin</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body class="min-h-screen bg-[#0b0805] text-[#f4ecd8] font-sans antialiased selection:bg-[#8a641d] selection:text-white">

    <div class="min-h-screen lg:flex">
        <!-- SIDEBAR (DESKTOP) -->
        <aside class="hidden lg:flex lg:w-72 lg:flex-col border-r border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md">
            
            <div class="flex flex-1 flex-col">
                <div class="border-b border-[#3c2c15] px-5 py-5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-[0_0_15px_rgba(207,159,63,0.3)]">
                            <i class="fa-solid fa-scissors text-2xl"></i>
                        </div>
                        <div class="leading-none">
                            <div class="font-['Bebas_Neue'] text-[2.1rem] tracking-[0.12em] text-[#f2d788]">TÂM</div>
                            <div class="mt-1 font-['Bebas_Neue'] text-[1.1rem] tracking-[0.18em] text-[#f4ecd8]">BARBERSHOP</div>
                        </div>
                    </a>
                </div>
                <nav class="flex flex-col gap-1 px-3 py-4 text-sm font-bold uppercase tracking-wider">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-3 py-2.5 text-[#f2d788] hover:border-[#8a641d] transition-all">
                        <i class="fa-solid fa-house"></i>
                        <span>Trang chủ</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-chart-line mr-2 text-[#8a641d]"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-calendar-check mr-2 text-[#8a641d]"></i> Lịch hẹn
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-concierge-bell mr-2 text-[#8a641d]"></i> Dịch vụ
                    </a>
                    <a href="{{ route('admin.hairstyles.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.hairstyles.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-scissors mr-2 text-[#8a641d]"></i> Kiểu tóc
                    </a>
                    <a href="{{ route('admin.barbers.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.barbers.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-user-tie mr-2 text-[#8a641d]"></i> Barber
                    </a>
                    <a href="{{ route('admin.portfolio.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.portfolio.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-images mr-2 text-[#8a641d]"></i> Thư viện
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.announcements.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-bullhorn mr-2 text-[#8a641d]"></i> Sự kiện
                    </a>
                    <a href="{{ route('admin.contact.index') }}" class="rounded-[2px] px-3 py-2.5 transition-colors {{ request()->routeIs('admin.contact.*') ? 'bg-[#251b0e] text-[#f2d788] border border-[#8a641d]' : 'text-[#f4ecd8] hover:bg-[#251b0e] hover:text-[#f2d788]' }}">
                        <i class="fa-solid fa-envelope mr-2 text-[#8a641d]"></i> Liên hệ
                    </a>

                    @auth
                        @if (auth()->user()->isSystemOwner())
                            <div class="mt-3 border-t border-[#3c2c15] pt-3">
                                <a href="{{ route('admin.system-owner.index') }}" class="flex items-center gap-2 rounded-[2px] border border-[#a8342f] bg-gradient-to-r from-[#7c1f22] via-[#251b0e] to-[#7c1f22] px-3 py-2.5 text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] transition-all hover:brightness-125 {{ request()->routeIs('admin.system-owner.index') ? 'ring-1 ring-[#f2d788]' : '' }}">
                                    <i class="fa-solid fa-crown text-xs text-[#f2d788]"></i>
                                    <span class="text-[11px] font-extrabold uppercase tracking-widest">Khu Vực Chủ Tiệm</span>
                                </a>
                            </div>
                        @endif
                    @endauth
                    <div class="border-t border-[#3c2c15] p-3 space-y-2">
                        @auth
                            @if (auth()->user()->isSystemOwner())
                                <a href="{{ route('settings') }}" title="Cài đặt tài khoản Quản lý tối cao" class="flex items-center justify-center rounded-[2px] border border-[#8a641d] bg-[#251b0e] px-3 py-2.5 text-[#f2d788] transition-all hover:border-[#f2d788] hover:bg-[#7c1f22] hover:text-white {{ request()->routeIs('settings*') ? 'bg-[#7c1f22] border-[#f2d788] text-white' : '' }}">
                                    <i class="fa-solid fa-gear text-sm"></i>
                                </a>
                            @endif

                            <form action="{{ route('logout', [], false) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3 py-2.5 text-[#0b0805] font-bold shadow transition-all hover:brightness-110 active:scale-95">
                                    Đăng xuất
                                </button>
                            </form>
                        @endauth
                    </div>
                </nav>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <!-- MOBILE HEADER -->
            <header class="sticky top-0 z-50 border-b border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md lg:hidden">
                <div class="mx-auto flex h-20 items-center justify-between px-4 sm:px-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-[0_0_15px_rgba(207,159,63,0.3)]">
                            <i class="fa-solid fa-scissors text-lg"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-['Bebas_Neue'] text-3xl tracking-wider text-[#f2d788] leading-none"><span class="text-[#f4ecd8]">Admin</span></span>
                        </div>
                    </a>

                    <button id="adminMobileMenuBtn" type="button" class="p-2 text-[#f2d788] hover:text-white focus:outline-none" onclick="toggleAdminMobileMenu()">
                        <i id="adminMobileMenuIcon" class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>

                <div id="adminMobileMenu" class="hidden border-t border-[#3c2c15] bg-[#171008] px-4 pt-3 pb-6 space-y-2 font-bold uppercase text-xs tracking-wider">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.dashboard') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-chart-line mr-2 text-[#8a641d]"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.bookings.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-calendar-check mr-2 text-[#8a641d]"></i> Lịch hẹn
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.services.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-concierge-bell mr-2 text-[#8a641d]"></i> Dịch vụ
                    </a>
                    <a href="{{ route('admin.hairstyles.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.hairstyles.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-scissors mr-2 text-[#8a641d]"></i> Kiểu tóc
                    </a>
                    <a href="{{ route('admin.barbers.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.barbers.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-user-tie mr-2 text-[#8a641d]"></i> Barber
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.announcements.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-bullhorn mr-2 text-[#8a641d]"></i> Sự kiện
                    </a>
                    <a href="{{ route('admin.contact.index') }}" class="block py-2 text-[#f4ecd8] hover:text-[#f2d788] {{ request()->routeIs('admin.contact.*') ? 'text-[#f2d788]' : '' }}">
                        <i class="fa-solid fa-envelope mr-2 text-[#8a641d]"></i> Liên hệ
                    </a>

                    @auth
                        @if (auth()->user()->isSystemOwner())
                            <div class="pt-2 border-t border-[#3c2c15]">
                                <a href="{{ route('admin.system-owner.index') }}" class="block rounded bg-gradient-to-r from-[#7c1f22] to-[#251b0e] p-2.5 text-[#f2d788] font-black border border-[#a8342f] text-center my-1">
                                    <i class="fa-solid fa-crown mr-1.5 text-[#f2d788]"></i> Khu Vực Chủ Tiệm
                                </a>
                                <a href="{{ route('settings') }}" class="block py-2 text-[#f2d788] hover:text-white">
                                    <i class="fa-solid fa-gear mr-2 text-[#8a641d]"></i> Cài đặt tài khoản
                                </a>
                            </div>
                        @endif

                        <div class="pt-2 border-t border-[#3c2c15] space-y-2">
                            <a href="{{ route('home') }}" class="block py-2 text-[#f2d788] hover:text-white">
                                <i class="fa-solid fa-house mr-2"></i> Quay về Trang chủ
                            </a>

                            <form action="{{ route('logout') }}" method="POST" class="pt-1">
                                @csrf
                                <button type="submit" class="w-full text-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] py-2.5 text-[#0b0805] font-extrabold uppercase">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </header>

            <div class="h-[3px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)]"></div>

            <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-[2px] border border-emerald-600/50 bg-emerald-950/40 p-4 text-emerald-400 text-sm shadow-lg flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-[2px] border border-rose-600/50 bg-rose-950/40 p-4 text-rose-300 text-sm shadow-lg">
                        <strong class="block mb-2 font-bold flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-base text-rose-400"></i> Đã có lỗi xảy ra:
                        </strong>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <footer class="border-t border-[#3c2c15] bg-[#171008] py-6 text-center text-xs text-[#6f6248]">
        <p>&copy; {{ date('Y') }} Tâm Barbershop Admin Panel.</p>
    </footer>

    <!-- SCRIPT ĐÓNG/MỞ MENU MOBILE -->
    <script>
        function toggleAdminMobileMenu() {
            const menu = document.getElementById('adminMobileMenu');
            const icon = document.getElementById('adminMobileMenuIcon');
            
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