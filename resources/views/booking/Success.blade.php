@extends('layouts.app')

@section('title', 'Đặt lịch thành công - Barbershop')

@section('content')

    <div class="auth-shell text-center">
        <div class="seal" style="margin-bottom:1.5rem;">
            ĐÃ<br><span style="font-size:1.5rem;">ĐẶT LỊCH</span><br><small>THÀNH CÔNG</small>
        </div>
        <h1>Đặt lịch thành công!</h1>
        <p>Mã đặt lịch của bạn: <strong class="eyebrow-gold">{{ $booking->booking_code }}</strong></p>

        <ul style="text-align:left; list-style:none; padding:0;">
            <li><strong>Khách hàng:</strong> {{ $booking->customer_name }}</li>
            <li><strong>Số điện thoại:</strong> {{ $booking->customer_phone }}</li>
            <li><strong>Dịch vụ:</strong> {{ $booking->service->name }}</li>
            <li><strong>Barber:</strong> {{ $booking->barber->name }}</li>
            <li><strong>Thời gian:</strong> {{ $booking->booking_time }} - {{ $booking->booking_date->format('d/m/Y') }}</li>
            <li><strong>Trạng thái:</strong> {{ $booking->status }}</li>
        </ul>

        <p class="muted">Tiệm sẽ liên hệ xác nhận với bạn qua số điện thoại đã đăng ký.</p>

        <a href="{{ route('home') }}" class="btn btn-outline">&larr; Về trang chủ</a>
    </div>

@endsection