@extends('layouts.app')

@section('title', 'Quên mật khẩu - Barbershop')

@section('content')

    <h1>Khôi phục mật khẩu</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label>Email đã đăng ký:
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <br>
        <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
    </form>

    <p><a href="{{ route('login') }}">&larr; Quay lại đăng nhập</a></p>

@endsection