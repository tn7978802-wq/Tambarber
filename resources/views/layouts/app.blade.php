<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản lý kho vật tư')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="font-semibold tracking-tight text-slate-900">
                Kho vật tư hạ tầng mạng &amp; CCTV
            </a>
            <nav class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('account.index') }}" class="text-slate-600 hover:text-slate-900">
                        {{ auth()->user()->fullname }}
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="font-medium text-slate-600 hover:text-slate-900">
                        Cài đặt
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="font-medium text-slate-600 hover:text-slate-900" type="submit">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:text-blue-900">Đăng nhập</a>
                @endauth
            </nav>
        </div>
    </header>
    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
