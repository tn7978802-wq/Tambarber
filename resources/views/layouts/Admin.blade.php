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
            <a href="{{ route('admin.bookings.index') }}">Lịch hẹn</a>
            |
            <a href="{{ route('admin.services.index') }}">Dịch vụ</a>
            |
            <a href="{{ route('admin.hairstyles.index') }}">Kiểu tóc</a>
            |
            <a href="{{ route('home') }}">Về trang chủ</a>
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