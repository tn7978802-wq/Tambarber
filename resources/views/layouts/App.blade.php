<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tâm-Barbershop')</title>
    {{-- Không gắn CSS framework sẵn ở đây - phần giao diện sẽ được thiết kế riêng sau. --}}
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body>

    <header>
        <nav>
            <a href="{{ route('home') }}"><strong>Tâm Barbershop</strong></a>
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
        <p>&copy; {{ date('Y') }}Tâm Barbershop. Mọi quyền được bảo lưu.</p>
        <p>
            Địa chỉ: 93/8A Lê Lợi,Hooc Môn,TPHCM &middot;
            Hotline: 0949146767 &middot;
            Giờ mở cửa: 08:00 - 20:00 (Tất cả các ngày trong tuần)
        </p>
    </footer>

</body>
</html>