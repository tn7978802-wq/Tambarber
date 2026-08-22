@extends('layouts.app')

@section('title', 'Quên mật khẩu - Barbershop')

@section('content')

    <div class="auth-shell">
        <div class="pole-divider small"></div>
        <h1>Khôi phục mật khẩu</h1>

        @if (session('status'))
            <p class="page-flash">{{ session('status') }}</p>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <label>Email đã đăng ký
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <button type="submit" class="btn btn-gold btn-block">Gửi liên kết đặt lại mật khẩu</button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">&larr; Quay lại đăng nhập</a>
        </div>
    </div>

@endsection