@extends('layouts.app')

@section('title', 'Đăng ký - Barbershop')

@section('content')

    <div class="auth-shell">
        <div class="pole-divider small"></div>
        <h1>Đăng ký tài khoản</h1>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <label>Họ và tên
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>
            <label>Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>Số điện thoại (không bắt buộc)
                <input type="text" name="phone" value="{{ old('phone') }}">
            </label>
            <label>Mật khẩu
                <input type="password" name="password" required>
            </label>
            <label>Xác nhận mật khẩu
                <input type="password" name="password_confirmation" required>
            </label>

            <button type="submit" class="btn btn-gold btn-block">Đăng ký</button>
        </form>

        <div class="auth-links">
            Đã có tài khoản? <a href="{{ route('login') }}" style="display:inline;">Đăng nhập</a>
        </div>
    </div>

@endsection