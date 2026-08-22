@extends('layouts.app')

@section('title', 'Đăng nhập Quản lý tối cao - Barbershop')

@section('content')

    <h1>Đăng nhập Quản lý tối cao</h1>
    <p>Khu vực dành riêng cho Chủ Tiệm (Root Owner) — đăng nhập bằng "Chìa khoá vạn năng" (Master Password) cấu hình trong .env.</p>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label>Email Chủ Tiệm:
            <input type="text" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        <br>
        <label>Master Password:
            <input type="password" name="password" required>
        </label>
        <br>
        <button type="submit">Đăng nhập</button>
    </form>

    <p><a href="{{ route('login') }}">&larr; Quay lại đăng nhập thường</a></p>

@endsection