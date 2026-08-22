<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') - Barbershop Admin</title>
</head>
<body>

    <header>
        <nav>
            <strong>Barbershop Admin</strong>
            |
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            |
            <a href="{{ route('admin.bookings.index') }}">Lịch hẹn</a>
            |
            <a href="{{ route('admin.services.index') }}">Dịch vụ</a>
            |
            <a href="{{ route('admin.hairstyles.index') }}">Kiểu tóc</a>
            @auth
                @if (auth()->user()->isSystemOwner())
                    |
                    <a href="{{ route('admin.system-owner.index') }}"><strong>Quản lý tối cao</strong></a>
                @endif
            @endauth
            |
            <a href="{{ route('home') }}">Về trang chủ</a>
            |
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Đăng xuất ({{ auth()->user()->fullname }})</button>
                </form>
            @endauth
        </nav>
    </header>

    <main>
        @if (session('success'))
            <p><strong>{{ session('success') }}</strong></p>
        @endif

        @yield('content')
    </main>

</body>
</html>