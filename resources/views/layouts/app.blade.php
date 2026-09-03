<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0b0805]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'TâmBarbershop') }}</title>

    <!-- Google Fonts cho Bebas Neue & Inter/Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/tailwind-base.css', 'resources/js/app.js'])

    <!-- Flatpickr Datepicker Theme Tối Barbershop -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Mặc định (Ngày + Giờ, từ hôm nay)
        const fpDefault = {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minuteIncrement: 1,
            minDate: "today",
            locale: { firstDayOfWeek: 1 }
        };

        // 2. Chỉ ngày (từ hôm nay)
        const fpDateOnly = {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: { firstDayOfWeek: 1 }
        };

        // 3. Cho phép quá khứ (Dùng cho Filter)
        const fpPast = {
            enableTime: false,
            dateFormat: "Y-m-d",
            locale: { firstDayOfWeek: 1 }
        };

        // Áp dụng
        flatpickr(".datepicker", fpDefault);
        flatpickr("#publish_at", fpDefault);
        flatpickr(".date-only-picker", fpDateOnly);
        flatpickr(".past-date-picker", fpPast);
    });
    </script>

    <style>
    /* Custom Flatpickr cho Barber Theme */
    .flatpickr-calendar {
        background: #171008 !important;
        border: 1px solid #3c2c15 !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.8) !important;
        border-radius: 4px !important;
    }
    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected:focus, .flatpickr-day.selected:hover {
        background: #8a641d !important;
        border-color: #f2d788 !important;
        color: #0b0805 !important;
        font-weight: bold !important;
    }
    .flatpickr-time input:hover, .flatpickr-time .flatpickr-am-pm:hover, .flatpickr-time input:focus, .flatpickr-time .flatpickr-am-pm:focus {
        background: #251b0e !important;
    }
    .flatpickr-calendar.hasTime .flatpickr-time {
        border-top: 1px solid #3c2c15 !important;
    }
    </style>
</head>

<body class="min-h-screen bg-[#0b0805] text-[#f4ecd8] font-sans antialiased selection:bg-[#8a641d] selection:text-white">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_minmax(0,1fr)]">
        
        <!-- SIDEBAR CHÍNH -->
        <aside class="hidden sticky top-0 h-screen overflow-y-auto border-r border-[#3c2c15] bg-[#171008] lg:flex lg:flex-col shadow-xl">
            <!-- Sidebar Header -->
            <div class="flex h-[80px] shrink-0 items-center border-b border-[#3c2c15] px-6 bg-[#0b0805]/50">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="flex h-11 w-11 items-center justify-center rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] text-[#0b0805] shadow-[0_4px_12px_rgba(207,159,63,0.3)]">
                        <i class="fa-solid fa-scissors text-lg"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#6f6248]">{{ __('ui.admin_panel') }}</div>
                        <div class="text-2xl tracking-[0.05em] text-[#f2d788] group-hover:text-[#cf9f3f] transition-colors leading-none" style="font-family: 'Bebas Neue', sans-serif;">
                            Tâm <span class="text-[#f4ecd8]">Barbershop</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-4 py-6 flex flex-col justify-between">
                <div>
                    <div class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#6f6248]">{{ __('ui.navigation') }}</div>
                    <nav class="space-y-1.5">
                        @php
                            $adminNav = [
                                'dashboard' => ['label' => __('ui.dashboard'), 'route' => 'admin.dashboard', 'icon' => 'fa-chart-line'],
                                'management' => ['label' => __('ui.management'), 'route' => 'admin.management', 'icon' => 'fa-layer-group'],
                                'posts' => ['label' => __('ui.posts'), 'route' => 'admin.posts.create', 'icon' => 'fa-newspaper'],
                                'actions' => ['label' => __('ui.actions'), 'route' => 'admin.actions', 'icon' => 'fa-bolt'],
                                'feedback' => ['label' => __('ui.feedback'), 'route' => 'admin.feedback', 'icon' => 'fa-comments'],
                            ];
                        @endphp

                        @foreach ($adminNav as $key => $item)
                            @php $isActive = ($activeTab ?? 'dashboard') === $key; @endphp
                            <a
                                href="{{ route($item['route']) }}"
                                class="{{ $isActive ? 'bg-[#251b0e] text-[#f2d788] border-[#8a641d] shadow-[0_4px_12px_rgba(0,0,0,0.5)]' : 'text-[#f4ecd8]/80 border-transparent hover:bg-[#251b0e]/50 hover:text-[#f2d788]' }} flex items-center gap-3 rounded-[2px] border px-4 py-3 text-xs font-semibold uppercase tracking-[0.05em] transition-all"
                            >
                                <i class="fa-solid {{ $item['icon'] }} w-5 text-center text-[#cf9f3f]"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach

                        @if(Auth::user()->isSystemOwner())
                            <div class="my-5 border-t border-[#3c2c15]"></div>
                            <div class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#a8342f]">{{ __('ui.owner_rights') }}</div>
                            <a
                                href="{{ route('admin.system-owner.index') }}"
                                class="{{ ($activeTab ?? '') === 'system_owner' ? 'bg-[#7c1f22]/30 text-[#f2d788] border-[#a8342f]' : 'text-[#f0c9c9] border-[#7c1f22]/30 hover:bg-[#7c1f22]/20 hover:text-[#f2d788]' }} flex items-center gap-3 rounded-[2px] border px-4 py-3 text-xs font-black uppercase tracking-[0.05em] transition-all"
                            >
                                <i class="fa-solid fa-crown w-5 text-center text-[#f2d788]"></i>
                                <span>System Owner</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Footer Sidebar Box -->
                <div class="mt-auto space-y-4 pt-6">
                    @if(!Auth::user()->isSystemOwner())
                    <div class="rounded-[2px] border border-[#8a641d]/40 bg-[#251b0e] p-4 shadow-lg">
                        <div class="flex h-9 w-9 items-center justify-center rounded-[2px] bg-[#8a641d] text-[#0b0805] mb-2 font-bold">
                            <i class="fa-solid fa-user-shield text-sm"></i>
                        </div>
                        <h3 class="text-xs font-bold text-[#f2d788] uppercase tracking-wider mb-1">{{ __('ui.supreme_login') }}</h3>
                        <p class="text-[11px] text-[#6f6248] leading-relaxed mb-3">
                            {{ __('ui.supreme_login_desc') }}
                        </p>
                        <a href="{{ route('system-owner.portal') }}" class="flex w-full items-center justify-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3 py-2 text-[11px] font-bold uppercase tracking-wider text-[#0b0805] transition-all hover:brightness-110">
                            <i class="fa-solid fa-crown text-[#0b0805]"></i>
                            <span>{{ __('ui.verify_now') }}</span>
                        </a>
                    </div>
                    @else
                    <div class="rounded-[2px] border border-[#8a641d]/50 bg-[#251b0e] p-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[2px] bg-[#8a641d] text-[#0b0805]">
                                <i class="fa-solid fa-crown text-sm"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-[#f2d788] uppercase tracking-wider">System Owner</div>
                                <div class="text-xs font-bold text-[#f4ecd8]">Đã xác thực</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="rounded-[2px] border border-[#3c2c15] bg-[#0b0805] p-3.5 text-center">
                        <div class="text-[10px] uppercase tracking-[0.2em] text-[#8a641d] font-semibold">Workspace</div>
                        <p class="mt-1 text-[11px] text-[#6f6248] font-mono">
                            V2.6.0 • {{ Auth::user()->fullname ?? Auth::user()->name }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#3c2c15] px-6 py-4 text-xs text-[#6f6248] bg-[#0b0805]/40">
                <div class="font-semibold text-[#f2d788] truncate">{{ Auth::user()->fullname ?? Auth::user()->name ?? 'Admin User' }}</div>
                <div class="mt-0.5 text-[11px]">Quản trị hệ thống</div>
            </div>
        </aside>

        <!-- NỘI DUNG CHÍNH BÊN PHẢI -->
        <div class="relative flex min-h-screen flex-col bg-[#0b0805]">
            
            <!-- HEADER BÊN TRÊN -->
            <header class="sticky top-0 z-30 border-b border-[#3c2c15] bg-[#171008]/95 backdrop-blur-md">
                <div class="flex min-h-[68px] items-center justify-between gap-2 px-4 py-3 sm:gap-4 sm:px-6 lg:h-[76px] lg:px-8 lg:py-0">
                    
                    <!-- Title Section -->
                    <div class="flex min-w-0 items-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#8a641d] bg-[#251b0e] text-[#f2d788] lg:hidden">
                            <i class="fa-solid fa-scissors"></i>
                        </a>
                        <div class="min-w-0">
                            <div class="hidden text-[10px] font-semibold uppercase tracking-[0.2em] text-[#6f6248] sm:block">Tâm Barbershop Admin</div>
                            <h1 class="truncate text-2xl sm:text-3xl font-normal tracking-[0.03em] text-[#f2d788] leading-none" style="font-family: 'Bebas Neue', sans-serif;">@yield('page-title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                        <a href="{{ route('home') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#3c2c15] bg-[#251b0e] text-xs font-semibold text-[#f4ecd8] transition hover:border-[#8a641d] hover:text-[#f2d788] md:w-auto md:px-3.5 md:gap-2">
                            <i class="fa-solid fa-house text-[#cf9f3f]"></i>
                            <span class="hidden md:inline uppercase tracking-wider text-[11px]">{{ __('ui.home') }}</span>
                        </a>

                        <!-- Language Switcher -->
                        <div class="hidden sm:flex items-center rounded-[2px] border border-[#3c2c15] bg-[#251b0e] p-1 text-[11px] font-bold">
                            <a href="{{ route('language.switch', 'vi') }}" class="rounded-[2px] px-2.5 py-1 transition-colors {{ app()->getLocale() === 'vi' ? 'bg-[#8a641d] text-[#0b0805]' : 'text-[#6f6248] hover:text-[#f2d788]' }}">VI</a>
                            <a href="{{ route('language.switch', 'en') }}" class="rounded-[2px] px-2.5 py-1 transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#8a641d] text-[#0b0805]' : 'text-[#6f6248] hover:text-[#f2d788]' }}">EN</a>
                        </div>

                        <!-- Search Input -->
                        <label class="hidden min-w-[200px] items-center gap-2.5 rounded-[2px] border border-[#3c2c15] bg-[#0b0805] px-3.5 py-2 xl:flex">
                            <i class="fa-solid fa-magnifying-glass text-xs text-[#6f6248]"></i>
                            <input type="text" placeholder="{{ __('ui.search_placeholder') }}" class="w-full border-0 bg-transparent p-0 text-xs text-[#f4ecd8] placeholder:text-[#6f6248] focus:outline-none focus:ring-0">
                        </label>

                        @if(!Auth::user()->isSystemOwner())
                        <a href="{{ route('system-owner.portal') }}" class="flex items-center gap-2 rounded-[2px] border border-[#8a641d] bg-gradient-to-b from-[#f2d788] via-[#cf9f3f] to-[#8a641d] px-3.5 py-2 text-xs font-bold text-[#0b0805] transition hover:brightness-110">
                            <i class="fa-solid fa-crown text-[#0b0805]"></i>
                            <span class="hidden md:inline uppercase tracking-wider text-[11px]">System Owner Login</span>
                        </a>
                        @endif

                        <!-- User Info -->
                        <div class="hidden items-center gap-3 rounded-[2px] border border-[#3c2c15] bg-[#251b0e] px-3 py-1.5 text-[#f4ecd8] sm:flex">
                            <div class="flex h-8 w-8 items-center justify-center rounded-[2px] bg-[#8a641d] font-bold text-[#0b0805] text-xs">
                                {{ mb_strtoupper(mb_substr(Auth::user()->fullname ?? Auth::user()->name ?? 'A', 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div class="hidden sm:block leading-tight">
                                <div class="text-xs font-semibold text-[#f2d788]">{{ Auth::user()->fullname ?? Auth::user()->name ?? 'Admin User' }}</div>
                                <div class="text-[10px] text-[#6f6248]">
                                    {{ Auth::user()->isSystemOwner() ? 'System Owner' : 'Administrator' }}
                                </div>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 text-xs font-semibold text-[#f0c9c9] transition hover:bg-[#7c1f22] hover:text-white md:w-auto md:px-3.5 md:gap-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span class="hidden md:inline uppercase tracking-wider text-[11px]">{{ __('ui.logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- BARBER POLE SEPARATOR -->
            <div class="h-[3px] bg-[repeating-linear-gradient(-45deg,#7c1f22_0_14px,#f4ecd8_14px_28px,#171008_28px_42px)]"></div>

            <!-- MAIN CONTENT AREA -->
            <main class="relative z-10 flex-1 px-4 py-6 sm:px-6 lg:px-8 max-w-[1400px] w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

   @yield('scripts') 
</body>
</html>
