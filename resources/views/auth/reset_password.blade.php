@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Barbershop')

@section('content')

    <div class="auth-shell">
        <div class="pole-divider small"></div>
        <h1>Đặt lại mật khẩu</h1>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label>Email
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
            </label>
            <label>Mật khẩu mới
                <input type="password" name="password" required>
            </label>
            <label>Xác nhận mật khẩu mới
                <input type="password" name="password_confirmation" required>
            </label>

            <button type="submit" class="btn btn-gold btn-block">Cập nhật mật khẩu</button>
        </form>
    </div>

@endsection