<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tổng quan kho') - Quản lý kho vật tư</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex min-h-16 items-center justify-between gap-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 font-semibold tracking-tight text-slate-900">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-blue-900 text-sm font-bold text-white">K</span>
                    <span class="hidden sm:inline">Kho vật tư <span class="text-slate-400">/</span> Mạng &amp; CCTV</span>
                </a>
                <nav class="flex items-center gap-1 overflow-x-auto text-sm">
                    @foreach ([
                        ['admin.dashboard', 'Tổng quan'],
                        ['admin.products.index', 'Vật tư'],
                        ['admin.transactions.index', 'Giao dịch'],
                        ['admin.categories.index', 'Danh mục'],
                        ['admin.suppliers.index', 'Nhà cung cấp'],
                        ['admin.projects.index', 'Dự án'],
                        ['admin.accounts.index', 'Tài khoản'],
                    ] as [$routeName, $label])
                        <a href="{{ route($routeName) }}"
                           class="whitespace-nowrap rounded-lg px-3 py-2 font-medium {{ request()->routeIs($routeName) ? 'bg-blue-50 text-blue-800' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
                <div class="hidden shrink-0 items-center gap-3 md:flex">
                    <span class="max-w-36 truncate text-sm text-slate-600">{{ auth()->user()->fullname }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
