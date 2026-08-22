<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tâm     Barbershop')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body>

    <header>
        <nav>
            <a href="{{ route('home') }}"><strong>Barbershop</strong></a>
            |
            <a href="{{ route('home') }}">Trang chủ</a>
            |
            <a href="{{ route('about') }}">Giới thiệu</a>
            |
            <a href="{{ route('hairstyles.index') }}">Kiểu tóc</a>
            |
            <a href="{{ route('services.index') }}">Dịch vụ</a>
            |
            <a href="{{ route('portfolio.index') }}">Portfolio</a>
            |
            <a href="{{ route('blog.index') }}">Blog</a>
            |
            <a href="{{ route('booking.create') }}">Đặt lịch</a>
            |
            <a href="{{ route('contact.index') }}">Liên hệ</a>
            |
            @auth
                <a href="{{ route('account.index') }}">Tài khoản của tôi</a>
                @if (auth()->user()->isAdmin())
                    |
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                @endif
                @if (auth()->user()->isSystemOwner())
                    |
                    <a href="{{ route('admin.system-owner.index') }}"><strong>Quản lý tối cao</strong></a>
                @endif
                |
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Đăng xuất ({{ auth()->user()->fullname }})</button>
                </form>
            @else
                <a href="{{ route('login') }}">Đăng nhập</a>
                |
                <a href="{{ route('register') }}">Đăng ký</a>
            @endauth
        </nav>
    </header>

    <main>
        @if (session('success'))
            <p><strong>{{ session('success') }}</strong></p>
        @endif

        @if ($errors->any())
            <div>
                <p><strong>Đã có lỗi xảy ra:</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <hr>
        <p>&copy; {{ date('Y') }} Barbershop. Mọi quyền được bảo lưu.</p>
        <p>
            Địa chỉ: 93/8A Lê Lợi,Hooc Môn,TPHCM &middot;
            Hotline: 0949146767 &middot;
            Giờ mở cửa: 08:00 - 20:00 (Tất cả các ngày trong tuần)
        </p>
    </footer>

</body>
</html>