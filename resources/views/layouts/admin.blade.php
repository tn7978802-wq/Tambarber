<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản trị') - Barbershop Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/barber.png') }}">
</head>
<body>

    <header class="site-header">
        <div class="nav-container">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                ✂️ Tâm Barbershop <span class="brand-tag">Admin</span>
            </a>

            {{-- Checkbox ẩn dùng để đóng/mở menu trên điện thoại, không cần JS. --}}
            <input type="checkbox" id="nav-toggle" class="nav-toggle-checkbox">
            <label for="nav-toggle" class="nav-toggle-btn" aria-label="Mở menu">&#9776;</label>

            <nav class="main-nav">
                <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                <a href="{{ route('admin.bookings.index') }}" @class(['is-active' => request()->routeIs('admin.bookings.*')])>Lịch hẹn</a>
                <a href="{{ route('admin.services.index') }}" @class(['is-active' => request()->routeIs('admin.services.*')])>Dịch vụ</a>
                <a href="{{ route('admin.hairstyles.index') }}" @class(['is-active' => request()->routeIs('admin.hairstyles.*')])>Kiểu tóc</a>
                <a href="{{ route('admin.barbers.index') }}" @class(['is-active' => request()->routeIs('admin.barbers.*')])>Barber</a>
                <a href="{{ route('admin.announcements.index') }}" @class(['is-active' => request()->routeIs('admin.announcements.*')])>Sự kiện</a>
                @auth
                    @if (auth()->user()->isSystemOwner())
                        <a href="{{ route('admin.system-owner.index') }}" class="is-owner" @class(['is-active' => request()->routeIs('admin.system-owner.*')])>Quản lý tối cao</a>
                    @endif
                @endauth

                <a href="{{ route('home') }}">Về trang chủ</a>
                <div class="nav-divider"></div>
                
            </nav>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                    @csrf
                    <button type="submit">Đăng xuất ({{ \Illuminate\Support\Str::limit(auth()->user()->fullname, 14) }})</button>
                </form>
            @endauth
        </div>
    </header>

    <main>
        <div class="admin-container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Đã có lỗi xảy ra:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>