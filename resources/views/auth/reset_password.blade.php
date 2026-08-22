@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Barbershop')

@section('content')

    <h1>Đặt lại mật khẩu</h1>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email:
            <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
        </label>
        <br>
        <label>Mật khẩu mới:
            <input type="password" name="password" required>
        </label>
        <br>
        <label>Xác nhận mật khẩu mới:
            <input type="password" name="password_confirmation" required>
        </label>
        <br>
        <button type="submit">Cập nhật mật khẩu</button>
    </form>

@endsection