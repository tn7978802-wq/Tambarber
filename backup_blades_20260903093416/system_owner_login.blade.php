@extends('layouts.app')

@section('title', 'Đăng nhập Quản lý tối cao - Barbershop')

@section('content')

    <div class="auth-shell" style="border-color:var(--rosewood-br); box-shadow:0 0 0 1px rgba(168,52,47,.35), 0 18px 40px -20px rgba(0,0,0,.8);">
        <div class="pole-divider small"></div>
        <h1>Đăng nhập Quản lý tối cao</h1>
        <p class="muted text-center">Khu vực dành riêng cho Chủ Tiệm — đăng nhập bằng "Chìa khoá vạn năng" (Master Login)</p>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <label>Email Chủ Tiệm
                <input type="text" name="email" value="{{ old('email') }}" required autofocus>
            </label>
            <label>Master Password
                <input type="password" name="password" required>
            </label>
            <button type="submit" class="btn btn-gold btn-block">Đăng nhập</button>
        </form>
        <div class="auth-links">
            <a href="{{ route('login') }}">&larr; Quay lại đăng nhập thường</a>
        </div>
    </div>

@endsection