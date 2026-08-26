<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TâmBarbershop')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body>

    <header class="site-header">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="brand">✂️ TâmBarbershop</a>

            {{-- Checkbox ẩn dùng để đóng/mở menu trên điện thoại, không cần JS. --}}
            <input type="checkbox" id="nav-toggle" class="nav-toggle-checkbox">
            <label for="nav-toggle" class="nav-toggle-btn" aria-label="Mở menu">&#9776;</label>

            <nav class="main-nav">
                <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Trang chủ</a>
                <a href="{{ route('about') }}" @class(['is-active' => request()->routeIs('about')])>Giới thiệu</a>
                <a href="{{ route('hairstyles.index') }}" @class(['is-active' => request()->routeIs('hairstyles.*')])>Kiểu tóc</a>
                <a href="{{ route('services.index') }}" @class(['is-active' => request()->routeIs('services.*')])>Dịch vụ</a>
                <a href="{{ route('portfolio.index') }}" @class(['is-active' => request()->routeIs('portfolio.*')])>Portfolio</a>
                <a href="{{ route('blog.index') }}" @class(['is-active' => request()->routeIs('blog.*')])>Blog</a>
                <a href="{{ route('announcements.index') }}" @class(['is-active' => request()->routeIs('announcements.*')])>Sự kiện</a>
                <a href="{{ route('contact.index') }}" @class(['is-active' => request()->routeIs('contact.*')])>Liên hệ</a>
                <a href="{{ route('booking.create') }}" class="btn-cta">Đặt lịch</a>

                <div class="nav-divider"></div>

                @auth
                    <a href="{{ route('account.index') }}" @class(['is-active' => request()->routeIs('account.*')])>
                        {{ \Illuminate\Support\Str::limit(auth()->user()->fullname, 14) }}
                    </a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @endif
                    @if (auth()->user()->isSystemOwner())
                        <a href="{{ route('admin.system-owner.index') }}">Quản lý tối cao</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                        @csrf
                        <button type="submit">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Đăng nhập</a>
                    <a href="{{ route('register') }}">Đăng ký</a>
                @endauth
            </nav>
        </div>
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