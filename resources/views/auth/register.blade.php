@extends('layouts.app')

@section('title', 'Đăng ký - Barbershop')

@section('content')

    <h1>Đăng ký tài khoản</h1>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <label>Họ và tên:
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        <br>
        <label>Email:
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <br>
        <label>Số điện thoại (không bắt buộc):
            <input type="text" name="phone" value="{{ old('phone') }}">
        </label>
        <br>
        <label>Mật khẩu:
            <input type="password" name="password" required>
        </label>
        <br>
        <label>Xác nhận mật khẩu:
            <input type="password" name="password_confirmation" required>
        </label>
        <br>
        <button type="submit">Đăng ký</button>
    </form>

    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>

@endsection