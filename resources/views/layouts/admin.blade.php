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

    <!-- Tailwind config + CDN; load app JS via Vite -->
    <script>
        tailwind = tailwind || {};
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#0b0805',
                        'ink-2': '#171008',
                        panel: '#504d47',
                        'panel-2': '#251b0e',
                        line: '#3c2c15',
                        gold: '#cf9f3f',
                        'gold-bright': '#f2d788',
                        'gold-deep': '#8a641d',
                        rosewood: '#7c1f22',
                        'rosewood-br': '#a8342f',
                        cream: '#f4ecd8'
                    },
                    fontFamily: {
                        display: ['"Bebas Neue"', 'Arial Narrow', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'Jost', 'ui-sans-serif', 'system-ui']
                    },
                    boxShadow: {
                        'gold-panel': '0 0 0 1px rgba(207,159,63,.35), 0 18px 40px -20px rgba(0,0,0,.8)'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body class="min-h-screen bg-[#0b0805] text-[#f4ecd8] font-sans antialiased selection:bg-[#8a641d] selection:text-white flex flex-col justify-between">

    <!-- ADMIN HEADER NAVBAR -->
    <header class="sticky top-0 z-50 border-b border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
            
            <!-- LOGO -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 shrink-0">
                <div class="flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-[0_0_15px_rgba(207,159,63,0.3)]">
                    <i class="fa-solid fa-scissors text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-['Bebas_Neue'] text-3xl tracking-wider text-[#f2d788] leading-none">
                        Tâm <span class="text-[#f4ecd8]">Admin</span>
                    </span>
                    @auth
                        @if (auth()->user()->isSystemOwner())
                            <span class="text-[9px] font-bold uppercase tracking-[0.25em] text-[#a8342f] flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-crown text-[8px] text-[#f2d788]"></i> System Owner
                            </span>
                        @endif
                    @endauth
                </div>
            </a>

            <!-- NAVIGATION LINKS -->
            <nav class="hidden lg:flex items-center gap-5 text-xs font-bold uppercase tracking-wider">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.dashboard') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.bookings.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Lịch hẹn</a>
                <a href="{{ route('admin.services.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.services.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Dịch vụ</a>
                <a href="{{ route('admin.hairstyles.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.hairstyles.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Kiểu tóc</a>
                <a href="{{ route('admin.barbers.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.barbers.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Barber</a>
                <a href="{{ route('admin.announcements.index') }}" class="transition-colors hover:text-[#f2d788] {{ request()->routeIs('admin.announcements.*') ? 'text-[#f2d788] border-b-2 border-[#8a641d] pb-1' : 'text-[#f4ecd8]' }}">Sự kiện</a>

                <!-- DÀNH RIÊNG CHO QUẢN LÝ TỐI CAO -->
                @auth
                    @if (auth()->user()->isSystemOwner())
                        <div class="h-4 w-[1px] bg-[#3c2c15]"></div>
                        <a href="{{ route('admin.system-owner.index') }}" 
                           class="relative group inline-flex items-center gap-1.5 rounded-[2px] border border-[#a8342f] bg-gradient-to-r from-[#7c1f22] via-[#251b0e] to-[#7c1f22] px-3 py-1.5 text-[11px] font-extrabold uppercase tracking-widest text-[#f2d788] shadow-[0_0_15px_rgba(168,52,47,0.4)] transition-all hover:brightness-125 hover:shadow-[0_0_20px_rgba(242,215,136,0.6)] {{ request()->routeIs('admin.system-owner.*') ? 'ring-1 ring-[#f2d788] border-[#f2d788]' : '' }}">
                            <i class="fa-solid fa-crown text-xs text-[#f2d788] animate-pulse"></i>
                            <span>Khu Vực Chủ Tiệm</span>
                        </a>
                    @endif
                @endauth

                <div class="h-4 w-[1px] bg-[#3c2c15]"></div>

                <a href="{{ route('home') }}" class="rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-3 py-1.5 text-[#f2d788] hover:border-[#8a641d] transition-all flex items-center gap-1">
                    <i class="fa-solid fa-house"></i>
                    <span>Trang chủ</span>
                </a>

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3.5 py-1.5 text-[#0b0805] font-bold shadow transition-all hover:brightness-110 active:scale-95">
                            Đăng xuất
                        </button>
                    </form>
                @endauth
            </nav>

        </div>
    </header>

    <!-- BARBER POLE LINE -->
    <div class="h-[3px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)]"></div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- ALERT MESSAGES -->
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

    <!-- FOOTER -->
    <footer class="border-t border-[#3c2c15] bg-[#171008] py-6 text-center text-xs text-[#6f6248]">
        <p>&copy; {{ date('Y') }} Tâm Barbershop Admin Panel.</p>
    </footer>

    @yield('scripts')
</body>
</html>