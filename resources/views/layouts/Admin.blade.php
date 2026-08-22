<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') - Barbershop Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body>

    <header class="site-header">
        <div class="container">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <span class="brand-mark" aria-hidden="true"></span>
                Barbershop Admin
            </a>
            <nav class="main-nav">
                <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" @class(['is-active' => request()->routeIs('admin.bookings.*')])>Lịch hẹn</a>
                <a href="{{ route('admin.services.index') }}" @class(['is-active' => request()->routeIs('admin.services.*')])>Dịch vụ</a>
                <a href="{{ route('admin.hairstyles.index') }}" @class(['is-active' => request()->routeIs('admin.hairstyles.*')])>Kiểu tóc</a>
                @auth
                    @if (auth()->user()->isSystemOwner())
                        <a href="{{ route('admin.system-owner.index') }}"><strong>Quản lý tối cao</strong></a>
                    @endif
                @endauth
                <span class="divider">|</span>
                <a href="{{ route('home') }}">Về trang chủ</a>
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-ghost">Đăng xuất ({{ auth()->user()->fullname }})</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            @if (session('success'))
                <div class="page-flash"><strong>{{ session('success') }}</strong></div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>