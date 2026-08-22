@extends('layouts.app')

@section('title', 'Đăng nhập - Barbershop')

@section('content')

    <h1>Đăng nhập</h1>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <label>Email hoặc Số điện thoại:
            <input type="text" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        <br>
        <label>Mật khẩu:
            <input type="password" name="password" required>
        </label>
        <br>
        <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
        <br>
        <button type="submit">Đăng nhập</button>
    </form>

    <p><a href="{{ route('password.request') }}">Quên mật khẩu?</a></p>
    <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>

    <hr>

    <p><a href="{{ route('google.login') }}">Đăng nhập bằng Google</a></p>

    <hr>

    <p><small><a href="{{ route('system-owner.portal') }}">Đăng nhập dành cho Quản lý tối cao &rarr;</a></small></p>

@endsection