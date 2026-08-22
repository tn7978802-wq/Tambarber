@extends('layouts.app')

@section('title', 'Đăng nhập - Barbershop')

@section('content')

    <div class="auth-shell">
        <div class="pole-divider small"></div>
        <h1>Đăng nhập</h1>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <label>Email hoặc Số điện thoại
                <input type="text" name="email" value="{{ old('email') }}" required autofocus>
            </label>
            <label>Mật khẩu
                <input type="password" name="password" required>
            </label>
            <label style="display:flex; align-items:center; gap:.4rem;">
                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            </label>

            <button type="submit" class="btn btn-gold btn-block">Đăng nhập</button>
        </form>

        <div class="auth-links">
            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            <span>Chưa có tài khoản? <a href="{{ route('register') }}" style="display:inline;">Đăng ký ngay</a></span>
        </div>

        <hr>

        <a href="{{ route('google.login') }}" class="btn btn-outline btn-block">Đăng nhập bằng Google</a>

        <p class="auth-links" style="margin-top:1.5rem;">
            <a href="{{ route('system-owner.portal') }}">Đăng nhập dành cho Quản lý tối cao &rarr;</a>
        </p>
    </div>

@endsection