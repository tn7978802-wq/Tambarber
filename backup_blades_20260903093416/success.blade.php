@extends('layouts.app')

@section('title', 'Đặt lịch thành công - Barbershop')

@section('content')

    <h1>Đặt lịch thành công!</h1>

    <p>Mã đặt lịch của bạn: <strong>{{ $booking->booking_code }}</strong></p>

    <ul>
        <li>Khách hàng: {{ $booking->customer_name }}</li>
        <li>Số điện thoại: {{ $booking->customer_phone }}</li>
        <li>Dịch vụ: {{ $booking->service->name }}</li>
        <li>Barber: {{ $booking->barber->name }}</li>
        <li>Thời gian: {{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}</li>
        <li>Trạng thái: {{ $booking->status }}</li>
    </ul>

    <p>Tiệm sẽ liên hệ xác nhận với bạn qua số điện thoại đã đăng ký.</p>

    <a href="{{ route('home') }}">&larr; Về trang chủ</a>

@endsection
